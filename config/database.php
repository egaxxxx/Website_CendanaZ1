<?php
/**
 * File Koneksi Database
 * Dibuat oleh: Mahasiswa Informatika Unmul
 * Untuk: Tugas Pemrograman Web - Cv. Cendana Travel
 */

// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Hananta123');
define('DB_NAME', 'cendana_travel');
define('DB_CHARSET', 'utf8mb4');

// Set timezone Indonesia (WIB)
date_default_timezone_set('Asia/Jakarta');

// Matikan error reporting untuk production
mysqli_report(MYSQLI_REPORT_OFF);
error_reporting(E_ALL);
ini_set('display_errors', 0);

/**
 * Fungsi untuk membuat koneksi database
 */
function createDatabaseConnection() {
    // Buat koneksi ke MySQL
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Cek apakah koneksi berhasil
    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }
    
    // Set charset UTF-8
    $conn->set_charset(DB_CHARSET);
    
    return $conn;
}

// Buat koneksi database
$conn = createDatabaseConnection();

/**
 * ============================================
 * FUNGSI-FUNGSI BANTUAN UNTUK DATABASE
 * ============================================
 */

/**
 * Fungsi untuk escape string (mencegah SQL injection)
 */
function escapeString($conn, $string) {
    return $conn->real_escape_string($string);
}

/**
 * Fungsi untuk eksekusi query SELECT dan return hasil
 */
function fetchAll($conn, $sql) {
    $result = $conn->query($sql);
    if (!$result) {
        return [];
    }
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    return $data;
}

/**
 * Fungsi untuk eksekusi query SELECT dan return satu baris
 */
function fetchOne($conn, $sql) {
    $result = $conn->query($sql);
    if (!$result) {
        return null;
    }
    
    return $result->fetch_assoc();
}

/**
 * ============================================
 * FUNGSI-FUNGSI UNTUK SESSION
 * ============================================
 */

/**
 * Fungsi untuk start session dengan aman
 */
function startSecureSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        
        // Regenerate session ID untuk keamanan
        if (!isset($_SESSION['initiated'])) {
            session_regenerate_id(true);
            $_SESSION['initiated'] = true;
        }
    }
}

/**
 * Fungsi untuk cek apakah admin sudah login
 */
function isAdminLoggedIn() {
    startSecureSession();
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Fungsi untuk set session admin saat login
 */
function setAdminSession($adminId, $username) {
    startSecureSession();
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = $adminId;
    $_SESSION['admin_username'] = $username;
    $_SESSION['login_time'] = time();
}

/**
 * Fungsi untuk hapus session admin saat logout
 */
function destroyAdminSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Hapus semua session variables
    $_SESSION = [];
    
    // Hapus session cookie
    if (isset($_COOKIE[session_name()])) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy session
    session_destroy();
}

/**
 * ============================================
 * FUNGSI UNTUK LOGGING (OPSIONAL)
 * ============================================
 */

/**
 * Fungsi untuk log aktivitas
 */
function logActivity($message, $type = 'INFO') {
    $logFile = __DIR__ . '/../logs/activity.log';
    $logDir = dirname($logFile);
    
    // Buat folder logs kalau belum ada
    if (!file_exists($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] [$type] $message" . PHP_EOL;
    
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Return koneksi untuk digunakan di file lain
return $conn;
?>
