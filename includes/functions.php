<?php
// fungsi-fungsi helper buat CRUD
// pakai mysqli aja biar gampang debug

require_once __DIR__ . '/../config/database.php';

// ambil data company info
function getCompanyInfo() {
    global $conn;
    $sql = "SELECT * FROM company_info WHERE id = 1";
    $result = fetchOne($conn, $sql);
    return $result ? $result : [];
}

// update company info
function updateCompanyInfo($data) {
    global $conn;
    
    $name = escapeString($conn, $data['name']);
    $whatsapp = escapeString($conn, $data['whatsapp']);
    $instagram = escapeString($conn, $data['instagram']);
    $email = escapeString($conn, $data['email']);
    $address = escapeString($conn, $data['address']);
    $hours = escapeString($conn, $data['hours']);
    $description = escapeString($conn, $data['description']);
    
    $sql = "UPDATE company_info SET 
            name = '$name',
            whatsapp = '$whatsapp',
            instagram = '$instagram',
            email = '$email',
            address = '$address',
            hours = '$hours',
            description = '$description',
            updated_at = CURRENT_TIMESTAMP
            WHERE id = 1";
            
    return $conn->query($sql);
}

// fungsi buat banner homepage

// ambil semua banner
function getAllBanners() {
    global $conn;
    $sql = "SELECT * FROM homepage_banners ORDER BY display_order ASC, id ASC";
    return fetchAll($conn, $sql);
}

// ambil banner by ID
function getBannerById($id) {
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM homepage_banners WHERE id = $id";
    return fetchOne($conn, $sql);
}

//
function addBanner($data, $imagePath = null) {
    global $conn;
    
    $title = escapeString($conn, $data['title']);
    $subtitle = escapeString($conn, $data['subtitle']);
    $image = $imagePath ? escapeString($conn, $imagePath) : '';
    $link_url = escapeString($conn, $data['link_url']);
    $is_active = isset($data['is_active']) ? 1 : 0;
    $display_order = intval($data['display_order']);
    
    $sql = "INSERT INTO homepage_banners (title, subtitle, image, link_url, is_active, display_order) 
            VALUES ('$title', '$subtitle', '$image', '$link_url', $is_active, $display_order)";
            
    return $conn->query($sql);
}

// update banner
function updateBanner($id, $data, $imagePath = null) {
    global $conn;
    
    $id = intval($id);
    $title = escapeString($conn, $data['title']);
    $subtitle = escapeString($conn, $data['subtitle']);
    $link_url = escapeString($conn, $data['link_url']);
    $is_active = isset($data['is_active']) ? 1 : 0;
    $display_order = intval($data['display_order']);
    
    $imageUpdate = "";
    if ($imagePath) {
        $image = escapeString($conn, $imagePath);
        $imageUpdate = ", image = '$image'";
    }
    
    $sql = "UPDATE homepage_banners SET 
            title = '$title',
            subtitle = '$subtitle',
            link_url = '$link_url',
            is_active = $is_active,
            display_order = $display_order,
            updated_at = CURRENT_TIMESTAMP
            $imageUpdate
            WHERE id = $id";
            
    return $conn->query($sql);
}

// hapus banner
function deleteBanner($id) {
    global $conn;
    $id = intval($id);
    
    // Ambil data banner untuk hapus file gambar
    $banner = getBannerById($id);
    if ($banner && $banner['image'] && file_exists($banner['image'])) {
        unlink($banner['image']);
    }
    
    $sql = "DELETE FROM homepage_banners WHERE id = $id";
    return $conn->query($sql);
}

// fungsi buat gallery

// ambil semua galeri
function getAllGallery() {
    global $conn;
    $sql = "SELECT * FROM gallery ORDER BY is_featured DESC, display_order ASC, id DESC";
    return fetchAll($conn, $sql);
}

// ambil galeri by ID
function getGalleryById($id) {
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM gallery WHERE id = $id";
    return fetchOne($conn, $sql);
}

// tambah galeri baru
function addGallery($data, $imagePath) {
    global $conn;
    
    $title = escapeString($conn, $data['title']);
    $description = escapeString($conn, $data['description']);
    $image = escapeString($conn, $imagePath);
    $category = escapeString($conn, $data['category']);
    $is_featured = isset($data['is_featured']) ? 1 : 0;
    $is_active = isset($data['is_active']) ? 1 : 0;
    $display_order = intval($data['display_order']);
    
    $sql = "INSERT INTO gallery (title, description, image, category, is_featured, is_active, display_order) 
            VALUES ('$title', '$description', '$image', '$category', $is_featured, $is_active, $display_order)";
            
    return $conn->query($sql);
}

// update galeri
function updateGallery($id, $data, $imagePath = null) {
    global $conn;
    
    $id = intval($id);
    $title = escapeString($conn, $data['title']);
    $description = escapeString($conn, $data['description']);
    $category = escapeString($conn, $data['category']);
    $is_featured = isset($data['is_featured']) ? 1 : 0;
    $is_active = isset($data['is_active']) ? 1 : 0;
    $display_order = intval($data['display_order']);
    
    $imageUpdate = "";
    if ($imagePath) {
        $image = escapeString($conn, $imagePath);
        $imageUpdate = ", image = '$image'";
    }
    
    $sql = "UPDATE gallery SET 
            title = '$title',
            description = '$description',
            category = '$category',
            is_featured = $is_featured,
            is_active = $is_active,
            display_order = $display_order,
            updated_at = CURRENT_TIMESTAMP
            $imageUpdate
            WHERE id = $id";
            
    return $conn->query($sql);
}

// hapus galeri
function deleteGallery($id) {
    global $conn;
    $id = intval($id);
    
    // Ambil data galeri untuk hapus file gambar
    $gallery = getGalleryById($id);
    if ($gallery && $gallery['image'] && file_exists($gallery['image'])) {
        unlink($gallery['image']);
    }
    
    $sql = "DELETE FROM gallery WHERE id = $id";
    return $conn->query($sql);
}

//

//
function getContactInfo() {
    global $conn;
    
    // Baca dari homepage_settings (PRIMARY SOURCE) - termasuk data footer
    $sql = "SELECT 
            company_name,
            company_whatsapp as whatsapp,
            company_email as email,
            company_address as address,
            company_hours as hours,
            company_instagram as instagram,
            company_tiktok as tiktok,
            footer_description,
            footer_copyright
            FROM homepage_settings WHERE id = 1";
    
    $result = fetchOne($conn, $sql);
    
    if ($result) {
        return $result;
    }
    
    // Fallback ke company_info jika homepage_settings kosong (untuk backward compatibility)
    $sql2 = "SELECT * FROM company_info WHERE id = 1";
    $result2 = fetchOne($conn, $sql2);
    return $result2 ? $result2 : [];
}

// Update informasi kontak - SYNC ke homepage_settings (PRIMARY) dan company_info (LEGACY)
function updateContactInfo($data) {
    global $conn;
    
    $whatsapp = escapeString($conn, $data['whatsapp']);
    $email = escapeString($conn, $data['email']);
    $address = escapeString($conn, $data['address']);
    $hours = escapeString($conn, $data['hours'] ?? '');
    $instagram = escapeString($conn, $data['instagram']);
    $tiktok = escapeString($conn, $data['tiktok'] ?? '');
    
    // DEBUG LOG
    error_log("=== UPDATE CONTACT INFO ===");
    error_log("Whatsapp: $whatsapp");
    error_log("Email: $email");
    error_log("Address: $address");
    error_log("Hours: $hours");
    error_log("Instagram: $instagram");
    error_log("TikTok: $tiktok");
    
    // PRIMARY: Update homepage_settings (DATA UTAMA untuk customer pages)
    $sql1 = "UPDATE homepage_settings SET 
            company_whatsapp = '$whatsapp',
            company_email = '$email',
            company_address = '$address',
            company_hours = '$hours',
            company_instagram = '$instagram',
            company_tiktok = '$tiktok',
            updated_at = CURRENT_TIMESTAMP
            WHERE id = 1";
    
    $result1 = $conn->query($sql1);
    
    if ($result1) {
        error_log("✅ homepage_settings updated successfully");
    } else {
        error_log("❌ homepage_settings update FAILED: " . $conn->error);
    }
    
    // LEGACY: Update company_info (untuk backward compatibility)
    $sql2 = "UPDATE company_info SET 
            whatsapp = '$whatsapp',
            email = '$email',
            address = '$address',
            instagram = '$instagram',
            tiktok = '$tiktok',
            updated_at = CURRENT_TIMESTAMP
            WHERE id = 1";
            
    $result2 = $conn->query($sql2);
    
    if ($result2) {
        error_log("✅ company_info updated successfully (legacy)");
    } else {
        error_log("⚠️ company_info update failed (not critical): " . $conn->error);
    }
    
    // Return success jika homepage_settings berhasil (yang penting)
    return $result1;
}

// ============================================
// HOMEPAGE SETTINGS FUNCTIONS
// ============================================

function getHomepageSettings() {
    global $conn;
    $sql = "SELECT * FROM homepage_settings WHERE id = 1";
    $result = fetchOne($conn, $sql);
    return $result ? $result : [];
}

function updateHomepageSettings($data) {
    global $conn;
    
    // DEBUG: Log incoming data
    error_log("=== UPDATE HOMEPAGE SETTINGS ===");
    error_log("company_hours: " . ($data['company_hours'] ?? 'NOT SET'));
    error_log("company_email: " . ($data['company_email'] ?? 'NOT SET'));
    error_log("company_address: " . ($data['company_address'] ?? 'NOT SET'));
    
    $company_name = escapeString($conn, $data['company_name']);
    $company_address = escapeString($conn, $data['company_address'] ?? '');
    $company_hours = escapeString($conn, $data['company_hours'] ?? '');
    $company_email = escapeString($conn, $data['company_email'] ?? '');
    $company_whatsapp = escapeString($conn, $data['company_whatsapp'] ?? '');
    $company_instagram = escapeString($conn, $data['company_instagram'] ?? '');
    $company_tiktok = escapeString($conn, $data['company_tiktok'] ?? '');
    $hero_title = escapeString($conn, $data['hero_title']);
    $hero_subtitle = escapeString($conn, $data['hero_subtitle']);
    $hero_description = escapeString($conn, $data['hero_description']);
    $hero_background = isset($data['hero_background']) ? escapeString($conn, $data['hero_background']) : '';
    $stats_years = escapeString($conn, $data['stats_years']);
    $stats_years_label = escapeString($conn, $data['stats_years_label']);
    $stats_customers = escapeString($conn, $data['stats_customers']);
    $stats_customers_label = escapeString($conn, $data['stats_customers_label']);
    $stats_rating = escapeString($conn, $data['stats_rating']);
    $stats_rating_label = escapeString($conn, $data['stats_rating']);
    $footer_description = escapeString($conn, $data['footer_description']);
    $footer_copyright = escapeString($conn, $data['footer_copyright']);
    
    // Hero settings for other pages
    $pemesanan_hero_title = escapeString($conn, $data['pemesanan_hero_title'] ?? '');
    $pemesanan_hero_description = escapeString($conn, $data['pemesanan_hero_description'] ?? '');
    $pemesanan_hero_background = isset($data['pemesanan_hero_background']) ? escapeString($conn, $data['pemesanan_hero_background']) : '';
    
    $galeri_hero_title = escapeString($conn, $data['galeri_hero_title'] ?? '');
    $galeri_hero_description = escapeString($conn, $data['galeri_hero_description'] ?? '');
    $galeri_hero_background = isset($data['galeri_hero_background']) ? escapeString($conn, $data['galeri_hero_background']) : '';
    
    $faq_hero_title = escapeString($conn, $data['faq_hero_title'] ?? '');
    $faq_hero_description = escapeString($conn, $data['faq_hero_description'] ?? '');
    $faq_hero_background = isset($data['faq_hero_background']) ? escapeString($conn, $data['faq_hero_background']) : '';
    
    $kontak_hero_title = escapeString($conn, $data['kontak_hero_title'] ?? '');
    $kontak_hero_description = escapeString($conn, $data['kontak_hero_description'] ?? '');
    $kontak_hero_background = isset($data['kontak_hero_background']) ? escapeString($conn, $data['kontak_hero_background']) : '';
    
    $sql = "UPDATE homepage_settings SET 
            company_name = '$company_name',
            company_address = '$company_address',
            company_hours = '$company_hours',
            company_email = '$company_email',
            company_whatsapp = '$company_whatsapp',
            company_instagram = '$company_instagram',
            company_tiktok = '$company_tiktok',
            hero_title = '$hero_title',
            hero_subtitle = '$hero_subtitle',
            hero_description = '$hero_description',
            hero_background = '$hero_background',
            stats_years = '$stats_years',
            stats_years_label = '$stats_years_label',
            stats_customers = '$stats_customers',
            stats_customers_label = '$stats_customers_label',
            stats_rating = '$stats_rating',
            stats_rating_label = '$stats_rating_label',
            footer_description = '$footer_description',
            footer_copyright = '$footer_copyright',
            pemesanan_hero_title = '$pemesanan_hero_title',
            pemesanan_hero_description = '$pemesanan_hero_description',
            pemesanan_hero_background = '$pemesanan_hero_background',
            galeri_hero_title = '$galeri_hero_title',
            galeri_hero_description = '$galeri_hero_description',
            galeri_hero_background = '$galeri_hero_background',
            faq_hero_title = '$faq_hero_title',
            faq_hero_description = '$faq_hero_description',
            faq_hero_background = '$faq_hero_background',
            kontak_hero_title = '$kontak_hero_title',
            kontak_hero_description = '$kontak_hero_description',
            kontak_hero_background = '$kontak_hero_background',
            updated_at = CURRENT_TIMESTAMP
            WHERE id = 1";
    
    // DEBUG: Log SQL query
    error_log("SQL Query: " . substr($sql, 0, 500));
    
    $result = $conn->query($sql);
    
    if ($result) {
        error_log("UPDATE SUCCESS - Rows affected: " . $conn->affected_rows);
    } else {
        error_log("UPDATE FAILED - Error: " . $conn->error);
    }
    
    return $result;
}

// Hapus background hero
function deleteHeroBackground($field) {
    global $conn;
    
    // Validasi field name untuk keamanan
    $allowedFields = [
        'hero_background',
        'pemesanan_hero_background',
        'galeri_hero_background',
        'faq_hero_background',
        'kontak_hero_background'
    ];
    
    if (!in_array($field, $allowedFields)) {
        return false;
    }
    
    // Ambil nama file lama
    $sql = "SELECT $field FROM homepage_settings WHERE id = 1";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        $oldFile = $row[$field];
        
        // Hapus file fisik jika ada - coba beberapa path kemungkinan
        if (!empty($oldFile)) {
            $filePaths = [
                'uploads/' . $oldFile,
                '../uploads/' . $oldFile,
                __DIR__ . '/../uploads/' . $oldFile
            ];
            
            foreach ($filePaths as $path) {
                if (file_exists($path)) {
                    @unlink($path);
                    break;
                }
            }
        }
    }
    
    // Set field ke empty string di database
    $sql = "UPDATE homepage_settings SET $field = '', updated_at = CURRENT_TIMESTAMP WHERE id = 1";
    return $conn->query($sql);
}

//

//
function getAllFAQ() {
    global $conn;
    $sql = "SELECT * FROM faq WHERE is_active = 1 ORDER BY category ASC, display_order ASC, id ASC";
    return fetchAll($conn, $sql);
}

//
function getFAQById($id) {
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM faq WHERE id = $id";
    return fetchOne($conn, $sql);
}

//
function addFAQ($data) {
    global $conn;
    
    $question = escapeString($conn, $data['question']);
    $answer = escapeString($conn, $data['answer']);
    $category = escapeString($conn, $data['category']);
    $is_active = isset($data['is_active']) ? 1 : 0;
    $display_order = intval($data['display_order']);
    
    $sql = "INSERT INTO faq (question, answer, category, is_active, display_order) 
            VALUES ('$question', '$answer', '$category', $is_active, $display_order)";
            
    return $conn->query($sql);
}

//
function updateFAQ($id, $data) {
    global $conn;
    
    $id = intval($id);
    $question = escapeString($conn, $data['question']);
    $answer = escapeString($conn, $data['answer']);
    $category = escapeString($conn, $data['category']);
    $is_active = isset($data['is_active']) ? 1 : 0;
    $display_order = intval($data['display_order']);
    
    $sql = "UPDATE faq SET 
            question = '$question',
            answer = '$answer',
            category = '$category',
            is_active = $is_active,
            display_order = $display_order,
            updated_at = CURRENT_TIMESTAMP
            WHERE id = $id";
            
    return $conn->query($sql);
}

//
function deleteFAQ($id) {
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM faq WHERE id = $id";
    return $conn->query($sql);
}

//

//
function getAllBookings() {
    global $conn;
    $sql = "SELECT * FROM bookings ORDER BY created_at DESC";
    return fetchAll($conn, $sql);
}

//
function getBookingById($id) {
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM bookings WHERE id = $id";
    return fetchOne($conn, $sql);
}

//
function updateBookingStatus($id, $bookingStatus, $paymentStatus) {
    global $conn;
    
    $id = intval($id);
    $bookingStatus = escapeString($conn, $bookingStatus);
    $paymentStatus = escapeString($conn, $paymentStatus);
    
    $sql = "UPDATE bookings SET 
            booking_status = '$bookingStatus',
            payment_status = '$paymentStatus',
            updated_at = CURRENT_TIMESTAMP
            WHERE id = $id";
            
    return $conn->query($sql);
}

//
function deleteBooking($id) {
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM bookings WHERE id = $id";
    return $conn->query($sql);
}

//
function generateBookingCode() {
    return 'BK' . date('Ymd') . rand(100, 999);
}

//

//
function uploadImage($file, $targetDir = 'uploads/') {
    // Validasi file upload
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
    // Validasi ukuran file (max 5MB)
    $maxSize = 5 * 1024 * 1024; // 5MB in bytes
    if ($file['size'] > $maxSize) {
        return false;
    }
    
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        return false;
    }
    
    // ✅ Gunakan nama file asli yang sudah di-sanitize
    $originalName = basename($file['name']);
    $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '', $originalName);
    $targetPath = $targetDir . $fileName;
    
    // Buat folder kalau belum ada
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // ✅ Return path RELATIF tanpa "uploads/" prefix
        // Contoh: "pesawat/Lionair.png" (bukan "uploads/pesawat/Lionair.png")
        return str_replace('uploads/', '', $targetPath);
    }
    
    return false;
}

//

//
function getDashboardStats() {
    global $conn;
    
    $stats = [];
    
    // Total layanan transportasi
    $result = fetchOne($conn, "SELECT COUNT(*) as total FROM transport_services WHERE is_active = 1");
    $stats['total_services'] = $result ? $result['total'] : 0;
    
    // Total galeri
    $result = fetchOne($conn, "SELECT COUNT(*) as total FROM gallery WHERE is_active = 1");
    $stats['total_gallery'] = $result ? $result['total'] : 0;
    
    // Total FAQ
    $result = fetchOne($conn, "SELECT COUNT(*) as total FROM faq WHERE is_active = 1");
    $stats['total_faq'] = $result ? $result['total'] : 0;
    
    return $stats;
}

//

//
function getAllTransportServices() {
    global $conn;
    $sql = "SELECT ts.*, tt.type_name 
            FROM transport_services ts
            LEFT JOIN transport_types tt ON ts.transport_type = tt.type_key
            ORDER BY ts.transport_type, ts.display_order ASC, ts.id DESC";
    return fetchAll($conn, $sql);
}

//
function getTransportServiceById($id) {
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM transport_services WHERE id = $id";
    return fetchOne($conn, $sql);
}

//
function getAllTransportTypes() {
    global $conn;
    $sql = "SELECT * FROM transport_types ORDER BY display_order ASC";
    return fetchAll($conn, $sql);
}

//
function addTransportService($data, $logoPath = null) {
    global $conn;
    
    $transport_type = escapeString($conn, $data['transport_type']);
    $name = escapeString($conn, $data['name']);
    $logo = $logoPath ? escapeString($conn, $logoPath) : '';
    $route = escapeString($conn, $data['route']);
    $price = escapeString($conn, $data['price']);
    $is_active = isset($data['is_active']) ? 1 : 0;
    $display_order = intval($data['display_order'] ?? 0);
    
    $sql = "INSERT INTO transport_services (transport_type, name, logo, route, price, is_active, display_order) 
            VALUES ('$transport_type', '$name', '$logo', '$route', '$price', $is_active, $display_order)";
            
    return $conn->query($sql);
}

//
function updateTransportService($id, $data, $logoPath = null) {
    global $conn;
    
    $id = intval($id);
    $transport_type = escapeString($conn, $data['transport_type']);
    $name = escapeString($conn, $data['name']);
    $route = escapeString($conn, $data['route']);
    $price = escapeString($conn, $data['price']);
    $is_active = isset($data['is_active']) ? 1 : 0;
    $display_order = intval($data['display_order'] ?? 0);
    
    $logoUpdate = "";
    if ($logoPath) {
        // ✅ HAPUS foto lama sebelum update dengan foto baru
        $oldData = fetchOne($conn, "SELECT logo FROM transport_services WHERE id = $id");
        if ($oldData && !empty($oldData['logo'])) {
            $oldLogoPath = 'uploads/' . $oldData['logo'];
            if (file_exists($oldLogoPath)) {
                unlink($oldLogoPath); // Hapus file lama
            }
        }
        
        $logo = escapeString($conn, $logoPath);
        $logoUpdate = ", logo = '$logo'";
    }
    
    $sql = "UPDATE transport_services SET 
            transport_type = '$transport_type',
            name = '$name',
            route = '$route',
            price = '$price',
            is_active = $is_active,
            display_order = $display_order,
            updated_at = CURRENT_TIMESTAMP
            $logoUpdate
            WHERE id = $id";
            
    return $conn->query($sql);
}

//
function deleteTransportService($id) {
    global $conn;
    $id = intval($id);
    
    // ✅ Hapus file logo sebelum hapus data
    $service = getTransportServiceById($id);
    if ($service && !empty($service['logo'])) {
        $logoPath = 'uploads/' . $service['logo'];
        if (file_exists($logoPath)) {
            unlink($logoPath); // Hapus file fisik
        }
    }
    
    $sql = "DELETE FROM transport_services WHERE id = $id";
    $result = $conn->query($sql);
    
    // OTOMATIS RE-ORDER ID setelah delete agar tidak ada gap (1,2,3,4,5... tanpa loncat)
    if ($result) {
        reorderTransportServiceIDs();
    }
    
    return $result;
}

// Fungsi untuk re-order ID transport services agar berurutan tanpa gap
// Ketika data ID 6 dihapus, data setelahnya akan turun (ID 7 jadi 6, ID 8 jadi 7, dst)
function reorderTransportServiceIDs() {
    global $conn;
    
    // 1. Ambil semua data yang ada (terurut)
    $sql = "SELECT * FROM transport_services ORDER BY id ASC";
    $services = fetchAll($conn, $sql);
    
    if (empty($services)) {
        return true;
    }
    
    // 2. Buat tabel temporary untuk backup
    $conn->query("DROP TABLE IF EXISTS transport_services_temp");
    $conn->query("CREATE TABLE transport_services_temp LIKE transport_services");
    
    // 3. Insert ke temporary dengan ID berurutan mulai dari 1
    foreach ($services as $index => $service) {
        $newId = $index + 1; // ID baru: 1, 2, 3, 4, 5...
        
        $transport_type = escapeString($conn, $service['transport_type']);
        $name = escapeString($conn, $service['name']);
        $logo = escapeString($conn, $service['logo']);
        $route = escapeString($conn, $service['route']);
        $price = escapeString($conn, $service['price']);
        $is_active = intval($service['is_active']);
        $display_order = intval($service['display_order']);
        $created_at = escapeString($conn, $service['created_at']);
        $updated_at = escapeString($conn, $service['updated_at']);
        
        $sql = "INSERT INTO transport_services_temp 
                (id, transport_type, name, logo, route, price, is_active, display_order, created_at, updated_at) 
                VALUES 
                ($newId, '$transport_type', '$name', '$logo', '$route', '$price', $is_active, $display_order, '$created_at', '$updated_at')";
        $conn->query($sql);
    }
    
    // 4. Hapus data lama
    $conn->query("DELETE FROM transport_services");
    
    // 5. Reset auto-increment
    $conn->query("ALTER TABLE transport_services AUTO_INCREMENT = 1");
    
    // 6. Copy kembali data dari temporary
    $conn->query("INSERT INTO transport_services SELECT * FROM transport_services_temp");
    
    // 7. Hapus temporary table
    $conn->query("DROP TABLE IF EXISTS transport_services_temp");
    
    return true;
}

//

//
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

//
function formatTanggal($tanggal) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    $timestamp = strtotime($tanggal);
    $hari = date('d', $timestamp);
    $bulan = $bulan[date('n', $timestamp)];
    $tahun = date('Y', $timestamp);
    
    return $hari . ' ' . $bulan . ' ' . $tahun;
}

//
function truncateText($text, $length = 100) {
    if (strlen($text) > $length) {
        return substr($text, 0, $length) . '...';
    }
    return $text;
}

// ============================================
// TRANSPORT ICONS LIBRARY FUNCTIONS
// ============================================

// Get all transport icons (optionally filter by category)
function getAllTransportIcons($category = null) {
    global $conn;
    
    $sql = "SELECT * FROM transport_icons";
    if ($category) {
        $category = escapeString($conn, $category);
        $sql .= " WHERE icon_category = '$category'";
    }
    $sql .= " ORDER BY icon_category, icon_name";
    
    return fetchAll($conn, $sql);
}

// Get transport icon by ID
function getTransportIconById($id) {
    global $conn;
    $id = intval($id);
    return fetchOne($conn, "SELECT * FROM transport_icons WHERE id = $id");
}

// Add new transport icon
function addTransportIcon($iconName, $iconFile, $iconCategory) {
    global $conn;
    
    $iconName = escapeString($conn, $iconName);
    $iconFile = escapeString($conn, $iconFile);
    $iconCategory = escapeString($conn, $iconCategory);
    
    $sql = "INSERT INTO transport_icons (icon_name, icon_file, icon_category) 
            VALUES ('$iconName', '$iconFile', '$iconCategory')";
            
    if ($conn->query($sql)) {
        return $conn->insert_id;
    }
    return false;
}

// Update transport icon
function updateTransportIcon($id, $iconName, $iconFile = null) {
    global $conn;
    
    $id = intval($id);
    $iconName = escapeString($conn, $iconName);
    
    $fileUpdate = "";
    if ($iconFile) {
        // Hapus file lama
        $oldIcon = getTransportIconById($id);
        if ($oldIcon && !empty($oldIcon['icon_file'])) {
            $oldPath = 'uploads/' . $oldIcon['icon_file'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        
        $iconFile = escapeString($conn, $iconFile);
        $fileUpdate = ", icon_file = '$iconFile'";
    }
    
    $sql = "UPDATE transport_icons SET 
            icon_name = '$iconName'
            $fileUpdate
            WHERE id = $id";
            
    return $conn->query($sql);
}

// Delete transport icon
function deleteTransportIcon($id) {
    global $conn;
    $id = intval($id);
    
    // Cek apakah icon sedang dipakai
    $inUse = fetchOne($conn, "SELECT COUNT(*) as count FROM transport_services WHERE logo = $id");
    if ($inUse && $inUse['count'] > 0) {
        return ['success' => false, 'message' => 'Icon sedang digunakan oleh ' . $inUse['count'] . ' transportasi. Tidak bisa dihapus!'];
    }
    
    // Hapus file fisik
    $icon = getTransportIconById($id);
    if ($icon && !empty($icon['icon_file'])) {
        $iconPath = 'uploads/' . $icon['icon_file'];
        if (file_exists($iconPath)) {
            unlink($iconPath);
        }
    }
    
    // Hapus dari database
    $sql = "DELETE FROM transport_icons WHERE id = $id";
    if ($conn->query($sql)) {
        return ['success' => true, 'message' => 'Icon berhasil dihapus!'];
    }
    return ['success' => false, 'message' => 'Gagal menghapus icon!'];
}

// Upload icon file (re-use uploadImage but return icon data)
function uploadTransportIcon($file, $iconName, $category) {
    // Upload file
    $iconFile = uploadImage($file, 'uploads/' . $category . '/');
    
    if ($iconFile) {
        // Save to database
        $iconId = addTransportIcon($iconName, $iconFile, $category);
        if ($iconId) {
            return [
                'success' => true,
                'icon_id' => $iconId,
                'icon_file' => $iconFile,
                'message' => 'Icon berhasil diupload!'
            ];
        }
    }
    
    return ['success' => false, 'message' => 'Gagal upload icon!'];
}

?>

