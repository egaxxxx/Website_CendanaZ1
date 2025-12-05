<?php
/**
 * ============================================
 * SETUP DATABASE - CV. CENDANA TRAVEL
 * ============================================
 * 
 * Script untuk setup database dan tabel
 * Jalankan file ini untuk membuat database dan tabel yang diperlukan
 * 
 * Cara menjalankan:
 * 1. Pastikan XAMPP/WAMP sudah running
 * 2. Buka browser dan akses: http://localhost/cendanaphp/setup_database.php
 * 3. Klik tombol "Setup Database"
 */

// Konfigurasi database
$host = 'localhost';
$username = 'root';
$password = 'Hananta123';
$database = 'cendana_travel';

echo "<h1>Setup Database CV. Cendana Travel</h1>";
echo "<p>Script ini akan membuat database dan tabel yang diperlukan untuk sistem admin.</p>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Koneksi ke MySQL tanpa database specific dulu
    try {
        $conn = new mysqli($host, $username, $password);
        
        if ($conn->connect_error) {
            die("<div style='color: red;'>Koneksi gagal: " . $conn->connect_error . "</div>");
        }
        
        echo "<h2>Status Setup:</h2>";
        
        // 1. Drop dan create database
        echo "<p>1. Membuat database '$database'...</p>";
        $conn->query("DROP DATABASE IF EXISTS $database");
        if ($conn->query("CREATE DATABASE $database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
            echo "<div style='color: green;'>✓ Database berhasil dibuat</div>";
        } else {
            echo "<div style='color: red;'>✗ Gagal membuat database: " . $conn->error . "</div>";
        }
        
        // 2. Pilih database
        $conn->select_db($database);
        
        // 3. Buat tabel company_info
        echo "<p>2. Membuat tabel company_info...</p>";
        $sql = "CREATE TABLE company_info (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL DEFAULT 'Cv. Cendana Travel',
            whatsapp VARCHAR(20) NOT NULL DEFAULT '6285821841529',
            instagram VARCHAR(100) NOT NULL DEFAULT '@cendanatravel_official',
            email VARCHAR(100) NOT NULL DEFAULT 'info@cendanatravel.com',
            address TEXT NOT NULL,
            hours VARCHAR(255) NOT NULL DEFAULT 'Senin - Minggu: 08.00 - 22.00 WIB',
            description TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        if ($conn->query($sql)) {
            echo "<div style='color: green;'>✓ Tabel company_info berhasil dibuat</div>";
            
            // Insert data default
            $sql = "INSERT INTO company_info (id, name, whatsapp, instagram, email, address, hours, description) VALUES
            (1, 'Cv. Cendana Travel', '6285821841529', '@cendanatravel_official', 'info@cendanatravel.com', 
            'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang<br>Kota Samarinda, Kalimantan Timur 75127',
            'Senin - Minggu: 08.00 - 22.00 WIB',
            'Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda. Berawal dari lokasi sederhana di depan masjid, kini kami telah berkembang dengan kantor cabang di Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur.')";
            $conn->query($sql);
        }
        
        // 4. Buat tabel homepage_banners
        echo "<p>3. Membuat tabel homepage_banners...</p>";
        $sql = "CREATE TABLE homepage_banners (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            subtitle TEXT DEFAULT NULL,
            image VARCHAR(255) NOT NULL,
            link_url VARCHAR(255) DEFAULT NULL,
            is_active TINYINT(1) DEFAULT 1,
            display_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        if ($conn->query($sql)) {
            echo "<div style='color: green;'>✓ Tabel homepage_banners berhasil dibuat</div>";
            
            // Insert data default
            $sql = "INSERT INTO homepage_banners (title, subtitle, image, display_order) VALUES
            ('Perjalanan Impian Anda Dimulai Dari Sini', 'Nikmati layanan travel terbaik dengan harga terjangkau dan pelayanan 24/7', 'uploads/banner1.jpg', 1),
            ('Jelajahi Indonesia Bersama Kami', 'Dari Sabang sampai Merauke, kami siap mengantarkan perjalanan Anda', 'uploads/banner2.jpg', 2),
            ('Booking Online, Mudah dan Terpercaya', 'Pesan tiket perjalanan Anda kapan saja, dimana saja dengan sistem booking online kami', 'uploads/banner3.jpg', 3)";
            $conn->query($sql);
        }
        
        // 5. Buat tabel gallery
        echo "<p>4. Membuat tabel gallery...</p>";
        $sql = "CREATE TABLE gallery (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            description TEXT DEFAULT NULL,
            image VARCHAR(255) NOT NULL,
            category VARCHAR(100) DEFAULT 'Umum',
            is_featured TINYINT(1) DEFAULT 0,
            is_active TINYINT(1) DEFAULT 1,
            display_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        if ($conn->query($sql)) {
            echo "<div style='color: green;'>✓ Tabel gallery berhasil dibuat</div>";
            
            // Insert data default
            $sql = "INSERT INTO gallery (title, description, image, category, is_featured, display_order) VALUES
            ('Kantor Pusat CV. Cendana Travel', 'Kantor pusat kami yang nyaman dan strategis di Samarinda', 'uploads/gallery/kantor1.jpg', 'Kantor', 1, 1),
            ('Ruang Tunggu VIP', 'Fasilitas ruang tunggu VIP dengan AC dan WiFi gratis', 'uploads/gallery/ruang-tunggu.jpg', 'Fasilitas', 1, 2),
            ('Armada Bus Pariwisata', 'Bus pariwisata dengan fasilitas lengkap dan nyaman', 'uploads/gallery/bus1.jpg', 'Transportasi', 1, 3),
            ('Tim Customer Service', 'Tim customer service yang ramah dan profesional', 'uploads/gallery/cs-team.jpg', 'Tim', 0, 4),
            ('Pelayanan 24 Jam', 'Kami siap melayani Anda 24 jam setiap hari', 'uploads/gallery/service24.jpg', 'Layanan', 0, 5)";
            $conn->query($sql);
        }
        
        // 6. Buat tabel contact_info
        echo "<p>5. Membuat tabel contact_info...</p>";
        $sql = "CREATE TABLE contact_info (
            id INT PRIMARY KEY AUTO_INCREMENT,
            phone VARCHAR(20) NOT NULL,
            whatsapp VARCHAR(20) NOT NULL,
            email VARCHAR(100) NOT NULL,
            address TEXT NOT NULL,
            maps_embed TEXT DEFAULT NULL,
            office_hours VARCHAR(255) NOT NULL DEFAULT 'Senin - Minggu: 08.00 - 22.00 WIB',
            facebook VARCHAR(255) DEFAULT NULL,
            instagram VARCHAR(255) DEFAULT NULL,
            twitter VARCHAR(255) DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        if ($conn->query($sql)) {
            echo "<div style='color: green;'>✓ Tabel contact_info berhasil dibuat</div>";
            
            // Insert data default
            $sql = "INSERT INTO contact_info (phone, whatsapp, email, address, maps_embed, instagram) VALUES
            ('(0541) 123456', '6285821841529', 'info@cendanatravel.com', 
            'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur 75127',
            '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.671234567890!2d117.123456!3d-0.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMDcnMjQuNCJTIDExN8KwMDcnMjQuNCJF!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid\" width=\"100%\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>',
            '@cendanatravel_official')";
            $conn->query($sql);
        }
        
        // 7. Buat tabel faq
        echo "<p>6. Membuat tabel faq...</p>";
        $sql = "CREATE TABLE faq (
            id INT PRIMARY KEY AUTO_INCREMENT,
            question TEXT NOT NULL,
            answer TEXT NOT NULL,
            category VARCHAR(100) DEFAULT 'Umum',
            is_active TINYINT(1) DEFAULT 1,
            display_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        if ($conn->query($sql)) {
            echo "<div style='color: green;'>✓ Tabel faq berhasil dibuat</div>";
            
            // Insert data default
            $sql = "INSERT INTO faq (question, answer, category, display_order) VALUES
            ('Bagaimana cara memesan tiket?', 'Anda dapat memesan tiket melalui website kami, WhatsApp, atau datang langsung ke kantor. Prosesnya sangat mudah dan cepat.', 'Pemesanan', 1),
            ('Apakah bisa refund tiket?', 'Ya, kami menyediakan layanan refund sesuai dengan syarat dan ketentuan yang berlaku. Biasanya dikenakan biaya administrasi.', 'Pembatalan', 2),
            ('Berapa lama sebelum keberangkatan harus booking?', 'Untuk memastikan ketersediaan tempat, kami sarankan booking minimal 2 hari sebelum keberangkatan.', 'Pemesanan', 3),
            ('Apakah ada layanan antar jemput?', 'Ya, kami menyediakan layanan antar jemput dengan biaya tambahan sesuai jarak lokasi Anda.', 'Layanan', 4),
            ('Bagaimana sistem pembayaran?', 'Kami menerima pembayaran tunai, transfer bank, e-wallet, dan kartu kredit. Pembayaran dapat dilakukan saat booking atau H-1 keberangkatan.', 'Pembayaran', 5)";
            $conn->query($sql);
        }
        
        // 8. Buat tabel bookings
        echo "<p>7. Membuat tabel bookings...</p>";
        $sql = "CREATE TABLE bookings (
            id INT PRIMARY KEY AUTO_INCREMENT,
            booking_code VARCHAR(20) NOT NULL UNIQUE,
            customer_name VARCHAR(255) NOT NULL,
            customer_phone VARCHAR(20) NOT NULL,
            customer_email VARCHAR(100) DEFAULT NULL,
            transport_type VARCHAR(50) NOT NULL,
            service_name VARCHAR(255) NOT NULL,
            route VARCHAR(255) NOT NULL,
            departure_date DATE NOT NULL,
            departure_time TIME DEFAULT NULL,
            passengers INT DEFAULT 1,
            total_price DECIMAL(12,2) NOT NULL,
            payment_status ENUM('pending', 'paid', 'cancelled', 'refunded') DEFAULT 'pending',
            booking_status ENUM('confirmed', 'cancelled', 'completed') DEFAULT 'confirmed',
            notes TEXT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        if ($conn->query($sql)) {
            echo "<div style='color: green;'>✓ Tabel bookings berhasil dibuat</div>";
            
            // Insert data default
            $sql = "INSERT INTO bookings (booking_code, customer_name, customer_phone, customer_email, transport_type, service_name, route, departure_date, departure_time, passengers, total_price, payment_status, booking_status) VALUES
            ('BK001', 'Ahmad Rizky', '081234567890', 'ahmad@email.com', 'pesawat', 'Lion Air', 'Samarinda - Jakarta', '2024-12-15', '10:30:00', 2, 1700000.00, 'paid', 'confirmed'),
            ('BK002', 'Siti Nurhaliza', '082345678901', 'siti@email.com', 'kapal', 'KM. Kelud', 'Samarinda - Balikpapan', '2024-12-16', '14:00:00', 1, 350000.00, 'pending', 'confirmed'),
            ('BK003', 'Budi Santoso', '083456789012', 'budi@email.com', 'bus', 'Bus Pariwisata', 'Samarinda - Tenggarong', '2024-12-17', '08:00:00', 3, 450000.00, 'paid', 'confirmed'),
            ('BK004', 'Maya Sari', '084567890123', 'maya@email.com', 'pesawat', 'Garuda Indonesia', 'Samarinda - Surabaya', '2024-12-18', '16:45:00', 1, 950000.00, 'cancelled', 'cancelled'),
            ('BK005', 'Andi Pratama', '085678901234', 'andi@email.com', 'kapal', 'Speedboat Express', 'Samarinda - Kutai', '2024-12-19', '09:15:00', 2, 700000.00, 'paid', 'completed')";
            $conn->query($sql);
        }
        
        // 9. Buat tabel admin_users
        echo "<p>8. Membuat tabel admin_users...</p>";
        $sql = "CREATE TABLE admin_users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(100) DEFAULT NULL,
            is_active TINYINT(1) DEFAULT 1,
            last_login TIMESTAMP NULL DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        if ($conn->query($sql)) {
            echo "<div style='color: green;'>✓ Tabel admin_users berhasil dibuat</div>";
            
            // Insert admin default (username: admin, password: admin123)
            $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $sql = "INSERT INTO admin_users (username, password, full_name, email) VALUES
            ('admin', '$hashedPassword', 'Administrator', 'admin@cendanatravel.com')";
            $conn->query($sql);
            echo "<div style='color: blue;'>✓ Admin user berhasil dibuat (username: admin, password: admin123)</div>";
        }
        
        echo "<br><h2>✅ Setup Database Selesai!</h2>";
        echo "<p><strong>Database dan tabel berhasil dibuat.</strong></p>";
        echo "<p>Anda sekarang bisa:</p>";
        echo "<ul>";
        echo "<li>Login ke admin dengan username: <strong>admin</strong> dan password: <strong>admin123</strong></li>";
        echo "<li>Akses halaman admin di: <a href='admin.php'>admin.php</a></li>";
        echo "<li>Mulai mengelola konten website CV. Cendana Travel</li>";
        echo "</ul>";
        
        $conn->close();
        
    } catch (Exception $e) {
        echo "<div style='color: red;'>Error: " . $e->getMessage() . "</div>";
    }
    
} else {
    // Tampilkan form setup
    ?>
    <form method="POST">
        <p><strong>Persiapan:</strong></p>
        <ul>
            <li>Pastikan XAMPP/WAMP sudah berjalan</li>
            <li>MySQL server sudah aktif</li>
            <li>Konfigurasi database sudah benar (host: localhost, user: root, password: kosong)</li>
        </ul>
        
        <br>
        <button type="submit" style="background: #007cba; color: white; padding: 15px 30px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
            🚀 Setup Database Sekarang
        </button>
    </form>
    
    <br><br>
    <p><small><em>Script ini akan membuat database 'cendana_travel' dan semua tabel yang diperlukan beserta data contoh.</em></small></p>
    <?php
}
?>