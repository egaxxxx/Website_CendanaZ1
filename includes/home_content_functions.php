<?php
// =====================================================
// FUNGSI CRUD KONTEN BERANDA DINAMIS
// CV. CENDANA TRAVEL
// =====================================================

require_once __DIR__ . '/../config/database.php';

// =====================================================
// MENGAPA MEMILIH KAMI (Why Choose Us)
// =====================================================

function getAllWhyChooseUs() {
    global $conn;
    $sql = "SELECT * FROM why_choose_us ORDER BY sort_order ASC, id ASC";
    $result = $conn->query($sql);
    if ($result === false) {
        error_log("SQL Error in getAllWhyChooseUs: " . $conn->error);
        return [];
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getWhyChooseUsById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM why_choose_us WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function createWhyChooseUs($data, $icon_file = null) {
    global $conn;
    
    $icon_path = null;
    if ($icon_file && $icon_file['error'] == 0) {
        $icon_path = uploadIcon($icon_file, 'why_choose_us');
    }
    
    $stmt = $conn->prepare("INSERT INTO why_choose_us (icon, title, description, sort_order) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $icon_path, $data['title'], $data['description'], $data['sort_order']);
    
    return $stmt->execute();
}

function updateWhyChooseUs($id, $data, $icon_file = null) {
    global $conn;
    
    // Get existing data
    $existing = getWhyChooseUsById($id);
    $icon_path = $existing['icon'];
    
    // Handle icon upload
    if ($icon_file && $icon_file['error'] == 0) {
        // Delete old icon
        if ($icon_path && file_exists($icon_path)) {
            unlink($icon_path);
        }
        $icon_path = uploadIcon($icon_file, 'why_choose_us');
    }
    
    $stmt = $conn->prepare("UPDATE why_choose_us SET icon = ?, title = ?, description = ?, sort_order = ? WHERE id = ?");
    $stmt->bind_param("sssii", $icon_path, $data['title'], $data['description'], $data['sort_order'], $id);
    
    return $stmt->execute();
}

function deleteWhyChooseUs($id) {
    global $conn;
    
    // Delete icon file
    $item = getWhyChooseUsById($id);
    if ($item && $item['icon'] && file_exists($item['icon'])) {
        unlink($item['icon']);
    }
    
    $stmt = $conn->prepare("DELETE FROM why_choose_us WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}

function toggleWhyChooseUsStatus($id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE why_choose_us SET is_active = NOT is_active WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// =====================================================
// CARA PEMBAYARAN (Payment Steps)
// =====================================================

function getAllPaymentSteps() {
    global $conn;
    $sql = "SELECT * FROM payment_steps ORDER BY sort_order ASC, id ASC";
    $result = $conn->query($sql);
    if ($result === false) {
        error_log("SQL Error in getAllPaymentSteps: " . $conn->error);
        return [];
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getPaymentStepById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM payment_steps WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function createPaymentStep($data, $icon_file = null) {
    global $conn;
    
    $icon_path = null;
    if ($icon_file && $icon_file['error'] == 0) {
        $icon_path = uploadIcon($icon_file, 'payment_steps');
    }
    
    $stmt = $conn->prepare("INSERT INTO payment_steps (icon, title, description, sort_order) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $icon_path, $data['title'], $data['description'], $data['sort_order']);
    
    return $stmt->execute();
}

function updatePaymentStep($id, $data, $icon_file = null) {
    global $conn;
    
    $existing = getPaymentStepById($id);
    $icon_path = $existing['icon'];
    
    if ($icon_file && $icon_file['error'] == 0) {
        if ($icon_path && file_exists($icon_path)) {
            unlink($icon_path);
        }
        $icon_path = uploadIcon($icon_file, 'payment_steps');
    }
    
    $stmt = $conn->prepare("UPDATE payment_steps SET icon = ?, title = ?, description = ?, sort_order = ? WHERE id = ?");
    $stmt->bind_param("sssii", $icon_path, $data['title'], $data['description'], $data['sort_order'], $id);
    
    return $stmt->execute();
}

function deletePaymentStep($id) {
    global $conn;
    
    $item = getPaymentStepById($id);
    if ($item && $item['icon'] && file_exists($item['icon'])) {
        unlink($item['icon']);
    }
    
    $stmt = $conn->prepare("DELETE FROM payment_steps WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}

function togglePaymentStepStatus($id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE payment_steps SET is_active = NOT is_active WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// =====================================================
// BAGAIMANA CARA MEMESAN (Order Steps)
// =====================================================

function getAllOrderSteps() {
    global $conn;
    $sql = "SELECT * FROM order_steps ORDER BY sort_order ASC, id ASC";
    $result = $conn->query($sql);
    if ($result === false) {
        error_log("SQL Error in getAllOrderSteps: " . $conn->error);
        return [];
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getOrderStepById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM order_steps WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function createOrderStep($data, $image_file = null) {
    global $conn;
    
    $image_path = null;
    if ($image_file && $image_file['error'] == 0) {
        $image_path = uploadOrderStepImage($image_file);
    }
    
    $stmt = $conn->prepare("INSERT INTO order_steps (image, title, description, sort_order) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $image_path, $data['title'], $data['description'], $data['sort_order']);
    
    return $stmt->execute();
}

function updateOrderStep($id, $data, $image_file = null) {
    global $conn;
    
    $existing = getOrderStepById($id);
    $image_path = $existing['image'];
    
    if ($image_file && $image_file['error'] == 0) {
        if ($image_path && file_exists($image_path)) {
            unlink($image_path);
        }
        $image_path = uploadOrderStepImage($image_file);
    }
    
    $stmt = $conn->prepare("UPDATE order_steps SET image = ?, title = ?, description = ?, sort_order = ? WHERE id = ?");
    $stmt->bind_param("sssii", $image_path, $data['title'], $data['description'], $data['sort_order'], $id);
    
    return $stmt->execute();
}

function deleteOrderStep($id) {
    global $conn;
    
    $item = getOrderStepById($id);
    if ($item && $item['image'] && file_exists($item['image'])) {
        unlink($item['image']);
    }
    
    $stmt = $conn->prepare("DELETE FROM order_steps WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}

function toggleOrderStepStatus($id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE order_steps SET is_active = NOT is_active WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// =====================================================
// GALERI BERANDA (Gallery Home Selection - MAX 3)
// =====================================================

function getAllGalleryHomeSelection() {
    global $conn;
    $sql = "SELECT ghs.*, g.title, g.image as image_path 
            FROM gallery_home_selection ghs
            LEFT JOIN gallery g ON ghs.gallery_id = g.id
            ORDER BY ghs.sort_order ASC, ghs.id ASC";
    $result = $conn->query($sql);
    
    // Handle query error
    if ($result === false) {
        error_log("SQL Error in getAllGalleryHomeSelection: " . $conn->error);
        return [];
    }
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getGalleryHomeSelectionCount() {
    global $conn;
    $sql = "SELECT COUNT(*) as count FROM gallery_home_selection";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

function getAllGalleryForSelection() {
    global $conn;
    $sql = "SELECT * FROM gallery ORDER BY created_at DESC";
    $result = $conn->query($sql);
    if ($result === false) {
        error_log("SQL Error in getAllGalleryForSelection: " . $conn->error);
        return [];
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getGalleryHomeSelectionById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT ghs.*, g.title, g.image as image_path 
                            FROM gallery_home_selection ghs
                            LEFT JOIN gallery g ON ghs.gallery_id = g.id
                            WHERE ghs.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function createGalleryHomeSelection($data) {
    global $conn;
    
    // Validasi: maksimal 3 foto
    if (getGalleryHomeSelectionCount() >= 3) {
        return ['success' => false, 'message' => 'Maksimal hanya 3 foto yang dapat ditampilkan di beranda'];
    }
    
    $stmt = $conn->prepare("INSERT INTO gallery_home_selection (gallery_id, description, sort_order) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $data['gallery_id'], $data['description'], $data['sort_order']);
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Foto berhasil ditambahkan ke beranda'];
    }
    return ['success' => false, 'message' => 'Gagal menambahkan foto'];
}

function updateGalleryHomeSelection($id, $data) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE gallery_home_selection SET gallery_id = ?, description = ?, sort_order = ? WHERE id = ?");
    $stmt->bind_param("isii", $data['gallery_id'], $data['description'], $data['sort_order'], $id);
    
    return $stmt->execute();
}

function deleteGalleryHomeSelection($id) {
    global $conn;
    
    $stmt = $conn->prepare("DELETE FROM gallery_home_selection WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}

// =====================================================
// LEGALITAS & KEAMANAN (Legal Security)
// =====================================================

function getAllLegalSecurity() {
    global $conn;
    $sql = "SELECT * FROM legal_security ORDER BY sort_order ASC, id ASC";
    $result = $conn->query($sql);
    if ($result === false) {
        error_log("SQL Error in getAllLegalSecurity: " . $conn->error);
        return [];
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getLegalSecurityById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM legal_security WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function createLegalSecurity($data, $icon_file = null) {
    global $conn;
    
    $icon_path = null;
    if ($icon_file && $icon_file['error'] == 0) {
        $icon_path = uploadIcon($icon_file, 'legal_security');
    }
    
    $stmt = $conn->prepare("INSERT INTO legal_security (icon, title, description, sort_order) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $icon_path, $data['title'], $data['description'], $data['sort_order']);
    
    return $stmt->execute();
}

function updateLegalSecurity($id, $data, $icon_file = null) {
    global $conn;
    
    $existing = getLegalSecurityById($id);
    $icon_path = $existing['icon'];
    
    if ($icon_file && $icon_file['error'] == 0) {
        if ($icon_path && file_exists($icon_path)) {
            unlink($icon_path);
        }
        $icon_path = uploadIcon($icon_file, 'legal_security');
    }
    
    $stmt = $conn->prepare("UPDATE legal_security SET icon = ?, title = ?, description = ?, sort_order = ? WHERE id = ?");
    $stmt->bind_param("sssii", $icon_path, $data['title'], $data['description'], $data['sort_order'], $id);
    
    return $stmt->execute();
}

function deleteLegalSecurity($id) {
    global $conn;
    
    $item = getLegalSecurityById($id);
    if ($item && $item['icon'] && file_exists($item['icon'])) {
        unlink($item['icon']);
    }
    
    $stmt = $conn->prepare("DELETE FROM legal_security WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}

function toggleLegalSecurityStatus($id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE legal_security SET is_active = NOT is_active WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// =====================================================
// HELPER FUNCTIONS - FILE UPLOAD
// =====================================================

function uploadIcon($file, $category) {
    $upload_dir = __DIR__ . '/../uploads/icons/';
    
    // Create directory if not exists
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
    
    if (!in_array($file_extension, $allowed_extensions)) {
        return null;
    }
    
    // Generate unique filename
    $filename = $category . '_' . uniqid() . '.' . $file_extension;
    $target_path = $upload_dir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return 'uploads/icons/' . $filename;
    }
    
    return null;
}

function uploadOrderStepImage($file) {
    $upload_dir = __DIR__ . '/../uploads/order_steps/';
    
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (!in_array($file_extension, $allowed_extensions)) {
        return null;
    }
    
    $filename = 'order_step_' . uniqid() . '.' . $file_extension;
    $target_path = $upload_dir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return 'uploads/order_steps/' . $filename;
    }
    
    return null;
}

// =====================================================
// UTILITY FUNCTIONS
// =====================================================

function getMaxSortOrder($table) {
    global $conn;
    $sql = "SELECT MAX(sort_order) as max_order FROM $table";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return ($row['max_order'] ?? 0) + 1;
}

?>
