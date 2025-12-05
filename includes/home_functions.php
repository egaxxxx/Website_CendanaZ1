<?php
/**
 * ============================================
 * FUNCTIONS FOR HOME PAGE SECTIONS CRUD
 * Fungsi untuk mengelola konten Beranda
 * ============================================
 */

// ============================================
// HOME SERVICES (Layanan Unggulan Kami)
// ============================================

function getAllHomeServices() {
    global $conn;
    $sql = "SELECT * FROM home_services ORDER BY display_order ASC, id ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getHomeServiceById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM home_services WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function addHomeService($title, $description, $icon_class, $display_order = 0) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO home_services (title, description, icon_class, display_order) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $title, $description, $icon_class, $display_order);
    return $stmt->execute();
}

function updateHomeService($id, $title, $description, $icon_class, $display_order, $is_active) {
    global $conn;
    $stmt = $conn->prepare("UPDATE home_services SET title=?, description=?, icon_class=?, display_order=?, is_active=? WHERE id=?");
    $stmt->bind_param("sssiii", $title, $description, $icon_class, $display_order, $is_active, $id);
    return $stmt->execute();
}

function deleteHomeService($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM home_services WHERE id=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// ============================================
// HOME WHY US (Mengapa Memilih Kami)
// ============================================

function getAllHomeWhyUs() {
    global $conn;
    $sql = "SELECT * FROM home_why_us ORDER BY display_order ASC, id ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getHomeWhyUsById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM home_why_us WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function addHomeWhyUs($title, $description, $icon_class, $display_order = 0) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO home_why_us (title, description, icon_class, display_order) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $title, $description, $icon_class, $display_order);
    return $stmt->execute();
}

function updateHomeWhyUs($id, $title, $description, $icon_class, $display_order, $is_active) {
    global $conn;
    $stmt = $conn->prepare("UPDATE home_why_us SET title=?, description=?, icon_class=?, display_order=?, is_active=? WHERE id=?");
    $stmt->bind_param("sssiii", $title, $description, $icon_class, $display_order, $is_active, $id);
    return $stmt->execute();
}

function deleteHomeWhyUs($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM home_why_us WHERE id=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// ============================================
// HOME PAYMENT METHODS (Cara Pembayaran)
// ============================================

function getAllHomePaymentMethods() {
    global $conn;
    $sql = "SELECT * FROM home_payment_methods ORDER BY display_order ASC, id ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getHomePaymentMethodById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM home_payment_methods WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function addHomePaymentMethod($title, $description, $icon_class, $display_order = 0) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO home_payment_methods (title, description, icon_class, display_order) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $title, $description, $icon_class, $display_order);
    return $stmt->execute();
}

function updateHomePaymentMethod($id, $title, $description, $icon_class, $display_order, $is_active) {
    global $conn;
    $stmt = $conn->prepare("UPDATE home_payment_methods SET title=?, description=?, icon_class=?, display_order=?, is_active=? WHERE id=?");
    $stmt->bind_param("sssiii", $title, $description, $icon_class, $display_order, $is_active, $id);
    return $stmt->execute();
}

function deleteHomePaymentMethod($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM home_payment_methods WHERE id=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// ============================================
// HOME BOOKING STEPS (Cara Memesan)
// ============================================

function getAllHomeBookingSteps() {
    global $conn;
    $sql = "SELECT * FROM home_booking_steps ORDER BY step_number ASC, id ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getHomeBookingStepById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM home_booking_steps WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function addHomeBookingStep($step_number, $title, $description) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO home_booking_steps (step_number, title, description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $step_number, $title, $description);
    return $stmt->execute();
}

function updateHomeBookingStep($id, $step_number, $title, $description, $is_active) {
    global $conn;
    $stmt = $conn->prepare("UPDATE home_booking_steps SET step_number=?, title=?, description=?, is_active=? WHERE id=?");
    $stmt->bind_param("issii", $step_number, $title, $description, $is_active, $id);
    return $stmt->execute();
}

function deleteHomeBookingStep($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM home_booking_steps WHERE id=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// ============================================
// HOME GALLERY (Galeri Beranda - Pilih dari galeri utama)
// ============================================

function getAllHomeGallery() {
    global $conn;
    $sql = "SELECT hg.*, g.title, g.image, g.category 
            FROM home_gallery hg 
            JOIN gallery g ON hg.gallery_id = g.id 
            WHERE hg.is_active = 1 
            ORDER BY hg.display_order ASC, hg.id ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getAvailableGalleryImages() {
    global $conn;
    // Get images yang belum dipilih untuk home gallery
    $sql = "SELECT g.* FROM gallery g 
            WHERE g.id NOT IN (SELECT gallery_id FROM home_gallery WHERE is_active = 1) 
            AND g.is_active = 1 
            ORDER BY g.created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function addHomeGallery($gallery_id, $display_order = 0) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO home_gallery (gallery_id, display_order) VALUES (?, ?)");
    $stmt->bind_param("ii", $gallery_id, $display_order);
    return $stmt->execute();
}

function deleteHomeGallery($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM home_gallery WHERE id=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function updateHomeGalleryOrder($id, $display_order) {
    global $conn;
    $stmt = $conn->prepare("UPDATE home_gallery SET display_order=? WHERE id=?");
    $stmt->bind_param("ii", $display_order, $id);
    return $stmt->execute();
}

// ============================================
// HOME LEGALITY (Legalitas & Keamanan)
// ============================================

function getAllHomeLegality() {
    global $conn;
    $sql = "SELECT * FROM home_legality ORDER BY display_order ASC, id ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getHomeLegalityById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM home_legality WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function addHomeLegality($title, $description, $icon_class, $display_order = 0) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO home_legality (title, description, icon_class, display_order) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $title, $description, $icon_class, $display_order);
    return $stmt->execute();
}

function updateHomeLegality($id, $title, $description, $icon_class, $display_order, $is_active) {
    global $conn;
    $stmt = $conn->prepare("UPDATE home_legality SET title=?, description=?, icon_class=?, display_order=?, is_active=? WHERE id=?");
    $stmt->bind_param("sssiii", $title, $description, $icon_class, $display_order, $is_active, $id);
    return $stmt->execute();
}

function deleteHomeLegality($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM home_legality WHERE id=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

?>
