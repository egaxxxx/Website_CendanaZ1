<?php
/**
 * SOLUSI: Halaman Pemesanan - Dengan Data dari Database
 * File: pemesanan.php (VERSI PERBAIKAN)
 * 
 * PERUBAHAN UTAMA:
 * 1. ✅ Menambahkan koneksi database
 * 2. ✅ Mengambil data transport dari database
 * 3. ✅ Generate data JSON untuk JavaScript
 * 4. ✅ Mengambil company info dari database
 */

// ========================================
// TAMBAHKAN DI BARIS 1-15 (SEBELUM <!DOCTYPE html>)
// ========================================

require_once 'config/database.php';
require_once 'includes/functions.php';

// Ambil company info dari database
$companyInfo = getCompanyInfo();

// Fallback jika database belum ada data
if (empty($companyInfo)) {
    $companyInfo = [
        'name' => 'CV. Cendana Travel',
        'whatsapp' => '6285821841529',
        'instagram' => '@cendanatravel_official',
        'email' => 'info@cendanatravel.com',
        'address' => 'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang<br>Kota Samarinda, Kalimantan Timur 75127',
        'hours' => 'Senin - Minggu: 08.00 - 22.00 WIB'
    ];
}

// Ambil semua data transport services dari database
$transportServices = getAllTransportServices();

// Pisahkan data berdasarkan tipe transportasi
$servicesData = [
    'pesawat' => [],
    'kapal' => [],
    'bus' => []
];

foreach ($transportServices as $service) {
    // Hanya ambil data yang aktif
    if ($service['is_active'] == 1) {
        $servicesData[$service['transport_type']][] = [
            'id' => $service['id'],
            'name' => $service['name'],
            'logo' => $service['logo'] ?: 'uploads/default-logo.png',
            'route' => $service['route'],
            'price' => $service['price'],
            'transportType' => $service['transport_type'],
            'displayOrder' => $service['display_order'],
            'updatedAt' => $service['updated_at']
        ];
    }
}

// Convert ke JSON untuk JavaScript
$servicesDataJSON = json_encode($servicesData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan - <?php echo htmlspecialchars($companyInfo['name']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="icons.css">
    <link rel="stylesheet" href="pemesanan-landscape.css">
    
    <!-- ========================================
         TAMBAHKAN SCRIPT INI DI <head>
         Untuk inject data dari database ke JavaScript
         ======================================== -->
    <script>
        // Data transport dari DATABASE (bukan dari config.js)
        const DATA_TRANSPORTASI_FROM_DB = <?php echo $servicesDataJSON; ?>;
        
        // Override data default dari config.js
        if (typeof DATA_TRANSPORTASI_DEFAULT === 'undefined') {
            var DATA_TRANSPORTASI_DEFAULT = DATA_TRANSPORTASI_FROM_DB;
        }
        
        console.log('✅ Data transport loaded from DATABASE:', DATA_TRANSPORTASI_FROM_DB);
        console.log('📊 Total services:', {
            pesawat: DATA_TRANSPORTASI_FROM_DB.pesawat.length,
            kapal: DATA_TRANSPORTASI_FROM_DB.kapal.length,
            bus: DATA_TRANSPORTASI_FROM_DB.bus.length
        });
    </script>
</head>
<body class="page-pemesanan">
    <!-- Header -->
    <header>
        <div class="container header-container">
            <!-- Logo Perusahaan -->
            <a href="index.php" class="logo"><?php echo htmlspecialchars($companyInfo['name']); ?></a>
            
            <!-- Menu Navigasi -->
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="pemesanan.php" class="active">Pemesanan</a></li>
                    <li><a href="galeri.php">Galeri</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                </ul>
            </nav>
            
            <!-- Kontrol Header (WhatsApp, Mode Gelap & Menu Mobile) -->
            <div class="header-controls">
                <!-- Tombol WhatsApp di header -->
                <a href="https://wa.me/<?php echo htmlspecialchars($companyInfo['whatsapp']); ?>" class="wa-header-btn" target="_blank" title="Hubungi via WhatsApp">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="wa-icon">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>
                    </svg>
                    <span>WhatsApp</span>
                </a>
                <!-- menu mobile -->
                <div class="mobile-menu" title="Menu">
                    <i class="icon icon-menu"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section with Gradient Background -->
    <section class="booking-hero">
        <div class="container">
            <div class="booking-hero-content">
                <h1 class="booking-hero-title">Temukan Tiket Perjalanan Terbaik</h1>
                <p class="booking-hero-subtitle">Pesan tiket pesawat, kapal, dan bus dengan harga terbaik. Proses cepat, aman, dan terpercaya untuk perjalanan Anda.</p>
            </div>
        </div>
        
        <!-- Decorative Background Elements -->
        <div class="hero-decoration">
            <div class="decoration-circle circle-1"></div>
            <div class="decoration-circle circle-2"></div>
            <div class="decoration-circle circle-3"></div>
        </div>
    </section>

    <!-- Filter Section with Modern Design -->
    <section class="booking-filter-section">
        <div class="container">
            <div class="filter-container">
                <div class="filter-header">
                    <h2 class="filter-title">Pilih Jenis Transportasi</h2>
                    <p class="filter-subtitle">Temukan layanan yang sesuai dengan kebutuhan perjalanan Anda</p>
                </div>
                <div class="filter-tabs" id="filterTabs">
                    <button class="filter-tab active" data-type="pesawat" onclick="bookingApp.switchFilter('pesawat')">
                        <div class="filter-tab-icon">
                            <i class="icon icon-plane"></i>
                        </div>
                        <div class="filter-tab-content">
                            <span class="filter-tab-name">Pesawat</span>
                            <span class="filter-tab-desc">Cepat & Efisien</span>
                        </div>
                        <div class="filter-tab-badge" id="badge-pesawat"><?php echo count($servicesData['pesawat']); ?></div>
                    </button>
                    <button class="filter-tab" data-type="kapal" onclick="bookingApp.switchFilter('kapal')">
                        <div class="filter-tab-icon">
                            <i class="icon icon-ship"></i>
                        </div>
                        <div class="filter-tab-content">
                            <span class="filter-tab-name">Kapal</span>
                            <span class="filter-tab-desc">Nyaman & Terjangkau</span>
                        </div>
                        <div class="filter-tab-badge" id="badge-kapal"><?php echo count($servicesData['kapal']); ?></div>
                    </button>
                    <button class="filter-tab" data-type="bus" onclick="bookingApp.switchFilter('bus')">
                        <div class="filter-tab-icon">
                            <i class="icon icon-bus"></i>
                        </div>
                        <div class="filter-tab-content">
                            <span class="filter-tab-name">Bus</span>
                            <span class="filter-tab-desc">Ekonomis & Praktis</span>
                        </div>
                        <div class="filter-tab-badge" id="badge-bus"><?php echo count($servicesData['bus']); ?></div>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <div class="section-header-inline">
                <div class="section-text">
                    <h2 class="section-title" id="sectionTitle">Pilihan Pesawat Terbaik</h2>
                    <p class="section-subtitle" id="sectionSubtitle"><?php echo count($servicesData['pesawat']); ?> pilihan layanan tersedia untuk Anda</p>
                </div>
            </div>
            
            <!-- Cards Container - Data akan di-render oleh JavaScript dari DATABASE -->
            <div class="services-grid" id="cardsContainer">
                <!-- JavaScript akan render cards di sini -->
                <div style="text-align: center; padding: 40px; color: #999;">
                    <p>⏳ Loading data from database...</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Modal (tetap sama) -->
    <div id="bookingModal" class="modal-overlay-landscape">
        <!-- ... (kode modal tetap sama) ... -->
    </div>

    <!-- Footer Premium (gunakan data dari database) -->
    <footer class="footer-premium">
        <div class="container">
            <!-- Main Grid: 4 Kolom -->
            <div class="footer-grid-premium">
                
                <!-- KOLOM 1: Tentang Kami -->
                <section class="footer-section-premium">
                    <h3 class="footer-heading-premium">Tentang Kami</h3>
                    <div class="footer-separator-premium"></div>
                    <p class="footer-text-premium">
                        Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun.
                    </p>
                    <div class="footer-hours-box">
                        <p class="footer-label-premium">Jam Operasional:</p>
                        <p class="footer-text-premium">
                            <?php echo htmlspecialchars($companyInfo['hours']); ?>
                        </p>
                    </div>
                </section>

                <!-- KOLOM 2: Menu Cepat -->
                <section class="footer-section-premium">
                    <h3 class="footer-heading-premium">Menu Cepat</h3>
                    <div class="footer-separator-premium"></div>
                    <ul class="footer-links-premium">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="pemesanan.php">Pemesanan</a></li>
                        <li><a href="galeri.php">Galeri</a></li>
                        <li><a href="kontak.php">Kontak</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                    </ul>
                </section>

                <!-- KOLOM 3: Layanan Kami -->
                <section class="footer-section-premium">
                    <h3 class="footer-heading-premium">Layanan Kami</h3>
                    <div class="footer-separator-premium"></div>
                    <ul class="footer-links-premium">
                        <li><a href="#">Paket Liburan</a></li>
                        <li><a href="#">Tiket Pesawat</a></li>
                        <li><a href="#">Hotel & Akomodasi</a></li>
                        <li><a href="#">Tour Guide</a></li>
                    </ul>
                </section>

                <!-- KOLOM 4: Hubungi Kami -->
                <section class="footer-section-premium">
                    <h3 class="footer-heading-premium">Hubungi Kami</h3>
                    <div class="footer-separator-premium"></div>
                    <div class="footer-contact-item">
                        <a href="https://wa.me/<?php echo htmlspecialchars($companyInfo['whatsapp']); ?>" class="footer-link-contact">📱 WhatsApp</a>
                    </div>
                    <div class="footer-contact-item">
                        <a href="https://wa.me/<?php echo htmlspecialchars($companyInfo['whatsapp']); ?>" class="footer-link-contact"><?php echo htmlspecialchars($companyInfo['whatsapp']); ?></a>
                    </div>
                    <div class="footer-contact-item">
                        <a href="mailto:<?php echo htmlspecialchars($companyInfo['email']); ?>" class="footer-link-contact">📧 Email</a>
                    </div>
                    <div class="footer-contact-item">
                        <p class="footer-label-premium">Alamat:</p>
                        <p class="footer-text-premium"><?php echo $companyInfo['address']; ?></p>
                    </div>
                </section>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom-premium">
                <p class="footer-copyright-premium">
                    &copy; 2024 <?php echo htmlspecialchars($companyInfo['name']); ?>. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <div class="wa-float">
        <a href="https://wa.me/<?php echo htmlspecialchars($companyInfo['whatsapp']); ?>" target="_blank">
            <i class="icon icon-whatsapp"></i>
        </a>
    </div>

    <!-- JavaScript -->
    <script src="pemesanan.js"></script>
    <script src="script.js"></script>
    
    <!-- ========================================
         TAMBAHKAN SCRIPT INI DI AKHIR <body>
         Untuk memastikan data dari database digunakan
         ======================================== -->
    <script>
        // Override data default dengan data dari database
        if (typeof bookingApp !== 'undefined' && DATA_TRANSPORTASI_FROM_DB) {
            bookingApp.servicesData = DATA_TRANSPORTASI_FROM_DB;
            console.log('✅ bookingApp.servicesData updated with database data');
            
            // Re-render cards dengan data terbaru
            bookingApp.renderCards(bookingApp.currentFilter);
            console.log('✅ Cards re-rendered with database data');
        }
    </script>
</body>
</html>
