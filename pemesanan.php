<?php
/**
 * Halaman Pemesanan Tiket - CV. Cendana Travel
 * UPDATED: Sekarang mengambil data dari DATABASE (bukan hardcoded)
 * FIXED: Auto-refresh data tanpa cache
 */

// Disable caching agar data selalu fresh dari database
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

// Load page configuration (company name, footer, etc)
require_once 'includes/page_config.php';

// Gunakan data LANGSUNG dari homepage_settings (via page_config.php)
$companyInfoData = [
    'name' => $companyName,
    'whatsapp' => $companyWhatsapp,
    'instagram' => $companyInstagram,
    'tiktok' => $companyTiktok,
    'email' => $companyEmail,
    'address' => $companyAddress,
    'hours' => $companyHours,
    'description' => $footerDescription
];

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
        // Fix logo path: add 'uploads/' prefix if not present
        $logoPath = $service['logo'];
        if (!empty($logoPath) && strpos($logoPath, 'uploads/') !== 0) {
            $logoPath = 'uploads/' . $logoPath;
        }
        if (empty($logoPath)) {
            $logoPath = 'uploads/default-logo.png';
        }
        
        $servicesData[$service['transport_type']][] = [
            'id' => $service['id'],
            'name' => $service['name'],
            'logo' => $logoPath,
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
    <title>Pemesanan - <?php echo htmlspecialchars($companyName); ?></title>
    
    <!-- 🔥 EXTREME CACHE BUSTING 🔥 -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <link rel="stylesheet" href="styles.css?v=<?php echo time() . mt_rand(); ?>">
    <link rel="stylesheet" href="icons.css?v=<?php echo time() . mt_rand(); ?>">
    <link rel="stylesheet" href="pemesanan-landscape.css?v=<?php echo time() . mt_rand(); ?>">
    
    <!-- ============================================
         ⚡ DATA 100% DARI DATABASE - REAL-TIME ⚡
         TIDAK MENGGUNAKAN config.js SAMA SEKALI!
         Semua data LANGSUNG dari database MySQL
         UPDATE, HAPUS, TAMBAH di admin = LANGSUNG SINKRON!
         ============================================ -->
    <script>
        // ==========================================
        // FORCE DISABLE config.js - GUNAKAN DATABASE ONLY!
        // ==========================================
        
        // Timestamp untuk prevent caching
        const DB_TIMESTAMP = <?php echo time(); ?>;
        const DB_DATE = '<?php echo date('Y-m-d H:i:s'); ?>';
        
        // 🔥 DATA DARI DATABASE - BUKAN dari config.js!
        const DATA_TRANSPORTASI_FROM_DB = <?php echo $servicesDataJSON; ?>;
        
        // 🔥 FORCE OVERRIDE - Ignore config.js completely!
        var DATA_TRANSPORTASI_DEFAULT = DATA_TRANSPORTASI_FROM_DB;
        
        // 🔥 BLOCK config.js data if it tries to load
        window.DATA_TRANSPORTASI_DEFAULT = DATA_TRANSPORTASI_FROM_DB;
        
        // LOG untuk debugging
        console.log('═══════════════════════════════════════════════════');
        console.log('🔥 DATA SOURCE: DATABASE (MySQL)');
        console.log('❌ config.js: DISABLED (data static diabaikan)');
        console.log('═══════════════════════════════════════════════════');
        console.log('🕐 Loaded at:', DB_DATE);
        console.log('📊 Total services from DATABASE:', {
            pesawat: DATA_TRANSPORTASI_FROM_DB.pesawat.length + ' items',
            kapal: DATA_TRANSPORTASI_FROM_DB.kapal.length + ' items',
            bus: DATA_TRANSPORTASI_FROM_DB.bus.length + ' items',
            TOTAL: (DATA_TRANSPORTASI_FROM_DB.pesawat.length + 
                    DATA_TRANSPORTASI_FROM_DB.kapal.length + 
                    DATA_TRANSPORTASI_FROM_DB.bus.length) + ' items'
        });
        console.log('═══════════════════════════════════════════════════');
        console.log('📝 SEMUA PESAWAT dari DATABASE:');
        DATA_TRANSPORTASI_FROM_DB.pesawat.forEach((item, i) => {
            console.log(`  ${i+1}. ${item.name} - ${item.price}`);
        });
        console.log('═══════════════════════════════════════════════════');
        console.log('✅ Tambah/Edit/Hapus di Admin Panel = LANGSUNG SINKRON!');
        console.log('✅ Refresh halaman (Ctrl+F5) untuk lihat perubahan');
        console.log('═══════════════════════════════════════════════════');
    </script>
</head>
<body class="page-pemesanan">
    <!-- Header -->
    <header>
        <div class="container header-container">
            <!-- Logo Perusahaan -->
            <a href="index.php" class="logo"><?php echo htmlspecialchars($companyName); ?></a>
            
            <!-- Menu Navigasi -->
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="pemesanan.php" class="active">Pemesanan</a></li>
                    <li><a href="galeri.php">Galeri</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                </ul>
            </nav>
            
            <!-- Kontrol Header (WhatsApp, Mode Gelap & Menu Mobile) -->
            <div class="header-controls">
                <!-- Tombol WhatsApp di header -->
                <a href="https://wa.me/<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>" class="wa-header-btn" target="_blank" title="Hubungi via WhatsApp">
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
    <section class="page-hero-standard" <?php if (!empty($homepageSettings['pemesanan_hero_background'])): ?>style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('uploads/<?php echo htmlspecialchars($homepageSettings['pemesanan_hero_background']); ?>'); background-size: cover; background-position: center;"<?php endif; ?>>
        <div class="container">
            <div class="page-hero-content">
                <h1 class="page-hero-title"><?php echo htmlspecialchars($homepageSettings['pemesanan_hero_title'] ?? 'Pemesanan Travel'); ?></h1>
                <p class="page-hero-subtitle"><?php echo htmlspecialchars($homepageSettings['pemesanan_hero_description'] ?? 'Pesan tiket pesawat, bus, dan kapal dengan mudah dan cepat'); ?></p>
            </div>
        </div>
        
        <!-- Decorative Background Elements -->
        <div class="hero-decoration">
            <div class="decoration-circle circle-1"></div>
            <div class="decoration-circle circle-2"></div>
            <div class="decoration-circle circle-3"></div>
        </div>
    </section>

    <!-- removed: Mengapa Pilih Kami (Pemesanan) -->

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
                            <span class="filter-tab-desc">Nyaman & Scenic</span>
                        </div>
                        <div class="filter-tab-badge" id="badge-kapal"><?php echo count($servicesData['kapal']); ?></div>
                    </button>
                    <button class="filter-tab" data-type="bus" onclick="bookingApp.switchFilter('bus')">
                        <div class="filter-tab-icon">
                            <i class="icon icon-bus"></i>
                        </div>
                        <div class="filter-tab-content">
                            <span class="filter-tab-name">Bus</span>
                            <span class="filter-tab-desc">Ekonomis & Fleksibel</span>
                        </div>
                        <div class="filter-tab-badge" id="badge-bus"><?php echo count($servicesData['bus']); ?></div>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Cards Container with Enhanced Layout -->
    <section class="booking-list-section">
        <div class="container">

            <!-- Cards Grid -->
            <div class="transport-cards-grid" id="cardsContainer">
                <!-- Cards will be rendered here by JavaScript -->
            </div>
        </div>
    </section>

    <!-- FAQ Pemesanan Section -->
    <section class="faq-booking-section">
        <div class="container">
            <div class="faq-booking-header">
                <h2>Pertanyaan Seputar Pemesanan</h2>
                <p>Jawaban untuk pertanyaan yang sering ditanyakan</p>
            </div>
            
            <div class="faq-booking-content">
                <?php
                require_once 'includes/faq_data.php';
                $faqPemesanan = getFaqByCategory('Pemesanan');
                
                foreach ($faqPemesanan as $index => $faq):
                ?>
                <div class="faq-booking-item">
                    <button class="faq-booking-question" onclick="toggleFaqBooking(<?php echo $index; ?>)">
                        <span><?php echo htmlspecialchars($faq['question']); ?></span>
                        <i class="icon icon-chevron-down faq-booking-icon" id="faq-icon-<?php echo $index; ?>"></i>
                    </button>
                    <div class="faq-booking-answer" id="faq-answer-<?php echo $index; ?>">
                        <p><?php echo $faq['answer']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="faq-booking-cta">
                <p>Punya pertanyaan lain?</p>
                <a href="faq.php" class="btn-faq-more">
                    <i class="icon icon-question-circle"></i>
                    Lihat Semua FAQ
                </a>
            </div>
        </div>
    </section>

    <!-- Booking Modal - Redesigned Landscape Two Column Layout -->
    <div class="booking-modal-overlay" id="bookingModal" style="display: none;">
        <div class="booking-modal booking-modal-landscape">
            <div class="booking-modal-header">
                <h3>Form Pemesanan Tiket</h3>
                <p class="booking-service-name" id="displayServiceName">Layanan</p>
                <button type="button" class="close-modal-btn" onclick="bookingApp.closeModal()">&times;</button>
            </div>
            <div class="booking-modal-body">
                <form id="bookingForm" onsubmit="bookingApp.submitForm(event)">
                    <input type="hidden" id="selectedService" name="service">
                    <input type="hidden" id="selectedType" name="type">
                    
                    <!-- Two Column Layout -->
                    <div class="form-columns">
                        <!-- Left Column -->
                        <div class="form-column form-column-left">
                            <div class="form-group">
                                <label>Nama Lengkap <span class="required">*</span></label>
                                <input type="text" id="customerName" name="nama" class="form-input" required placeholder="Masukkan nama lengkap">
                            </div>
                            
                            <div class="form-group">
                                <label>Asal <span class="required">*</span></label>
                                <input type="text" id="origin" name="asal" class="form-input" required placeholder="Kota asal">
                            </div>
                            
                            <div class="form-group">
                                <label>Tujuan <span class="required">*</span></label>
                                <input type="text" id="destination" name="tujuan" class="form-input" required placeholder="Kota tujuan">
                            </div>
                            
                            <div class="form-group">
                                <label>Kelas Perjalanan <span class="required">*</span></label>
                                <select id="kelasPerjalanan" name="kelas_perjalanan" class="form-input form-select" required>
                                    <option value="">Pilih Kelas</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Jumlah Penumpang</label>
                                <input type="number" id="passengers" name="penumpang" class="form-input" value="1" min="1" max="9">
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="form-column form-column-right">
                            <div class="form-group">
                                <label>Tanggal Berangkat <span class="required">*</span></label>
                                <input type="date" id="travelDate" name="tanggal" class="form-input" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            
                            <div class="form-group form-group-fullwidth">
                                <label>Pesan Tambahan</label>
                                <textarea id="additionalMessage" name="pesan" class="form-input form-textarea" rows="6" placeholder="Pesan atau permintaan khusus (opsional)"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions - Full Width Below -->
                    <div class="form-actions-landscape">
                        <button type="button" class="btn-cancel" onclick="bookingApp.closeModal()">Batal</button>
                        <button type="submit" class="btn-submit btn-submit-whatsapp">
                            <i class="icon icon-whatsapp"></i> Kirim via WhatsApp
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer Premium -->
    <footer class="footer-premium">
        <div class="container">
            <!-- Main Grid: 3 Kolom -->
            <div class="footer-grid-premium">
                
                <!-- KOLOM 1: Tentang Kami -->
                <section class="footer-section-premium">
                    <h3 class="footer-heading-premium">Tentang Kami</h3>
                    <div class="footer-separator-premium"></div>
                    <p class="footer-text-premium">
                        Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda. Berawal dari lokasi sederhana, kini kami siap melayani kebutuhan liburan Anda.
                    </p>
                    <div class="footer-hours-box">
                        <p class="footer-label-premium">Jam Operasional:</p>
                        <p class="footer-text-premium">
                            <?php echo htmlspecialchars($companyHours); ?>
                        </p>
                    </div>
                </section>

                <!-- KOLOM 2: Navigasi -->
                <section class="footer-section-premium">
                    <h3 class="footer-heading-premium">Navigasi</h3>
                    <div class="footer-separator-premium"></div>
                    <ul class="footer-links-premium">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="pemesanan.php">Pemesanan</a></li>
                        <li><a href="galeri.php">Galen</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                        <li><a href="kontak.php">Kontak</a></li>
                    </ul>
                </section>

                <!-- KOLOM 3: Hubungi Kami -->
                <section class="footer-section-premium">
                    <h3 class="footer-heading-premium">Hubungi Kami</h3>
                    <div class="footer-separator-premium"></div>
                    <div class="footer-contact-item">
                        <i class="fab fa-whatsapp" style="color: #25D366; margin-right: 8px;"></i>
                        <div>
                            <p class="footer-label-premium">WhatsApp</p>
                            <a href="https://wa.me/6285821841529" class="footer-link-contact">
                                0858-2184-1529
                            </a>
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-envelope" style="color: #E8B89A; margin-right: 8px;"></i>
                        <div>
                            <p class="footer-label-premium">Email</p>
                            <a href="mailto:admin@cendanatravel.com" class="footer-link-contact">
                                admin@cendanatravel.com
                            </a>
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-map-marker-alt" style="color: #E8B89A; margin-right: 8px;"></i>
                        <div>
                            <p class="footer-label-premium">Alamat</p>
                            <p class="footer-text-premium footer-address">
                                <?php echo nl2br(htmlspecialchars($companyAddress)); ?>
                            </p>
                        </div>
                    </div>
                </section>

            </div>

            <!-- Footer Bottom: Copyright & Admin Login -->
            <div class="footer-bottom-premium">
                <p class="footer-copyright-premium">
                    <?php echo htmlspecialchars($footerCopyright); ?>
                </p>
                <a href="auth.php" class="footer-admin-login">
                    <i class="fas fa-sign-in-alt"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <div class="wa-float">
        <a href="https://wa.me/<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>" target="_blank">
            <i class="icon icon-whatsapp"></i>
        </a>
    </div>

    <!-- Admin Login Modal -->
    <div class="admin-login-overlay" id="adminLoginOverlay" style="display: none;">
        <div class="admin-login-modal">
            <div class="admin-login-header">
                <h3>🔐 Admin Access</h3>
                <button class="close-modal" onclick="closeAdminLogin()">
                    <i class="icon icon-times"></i>
                </button>
            </div>
            <div class="admin-login-body">
                <p>Masukkan password untuk mengakses dashboard admin</p>
                <div class="password-input-group">
                    <input type="password" id="adminPassword" placeholder="Password" maxlength="50">
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                        <i class="icon icon-eye" id="passwordToggleIcon"></i>
                    </button>
                </div>
                <div class="admin-login-actions">
                    <button class="btn-admin-login" onclick="attemptAdminLogin()">
                        <i class="icon icon-sign-in"></i> Login
                    </button>
                    <button class="btn-admin-cancel" onclick="closeAdminLogin()">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        window.COMPANY_WHATSAPP = '<?php echo htmlspecialchars($companyInfoData["whatsapp"]); ?>';
        
        // Toggle FAQ Accordion
        function toggleFaqBooking(index) {
            const item = document.getElementById('faq-answer-' + index).parentElement;
            const allItems = document.querySelectorAll('.faq-booking-item');
            
            // Close all other items
            allItems.forEach((otherItem, i) => {
                if (i !== index && otherItem.classList.contains('active')) {
                    otherItem.classList.remove('active');
                }
            });
            
            // Toggle current item
            item.classList.toggle('active');
        }
        
        // Debug: Test modal visibility
        window.testModal = function() {
            const modal = document.getElementById('bookingModal');
            console.log('Modal element:', modal);
            if (modal) {
                modal.style.display = 'flex';
                console.log('Modal should now be visible');
            } else {
                console.error('Modal not found!');
            }
        };
    </script>
    
    <!-- ============================================
         ❌ config.js DINONAKTIFKAN! ❌
         Data sekarang 100% dari DATABASE (MySQL)
         ============================================ -->
    <!-- <script src="config.js?v=<?php echo time(); ?>"></script> -->
    
    <script src="script.js?v=<?php echo time() . mt_rand(); ?>"></script>
    <script src="pemesanan.js?v=<?php echo time() . mt_rand(); ?>"></script>
    
    <!-- ============================================
         🔥 FORCE OVERRIDE - DATABASE ONLY! 🔥
         Semua data dari MySQL database
         Tidak pakai config.js sama sekali!
         ============================================ -->
    <script>
        console.log('═══════════════════════════════════════════════════');
        console.log('🔥 STAGE 2: Override bookingApp with DATABASE data');
        console.log('═══════════════════════════════════════════════════');
        
        // 🔥 FORCE OVERRIDE bookingApp dengan data dari database
        if (typeof bookingApp !== 'undefined' && DATA_TRANSPORTASI_FROM_DB) {
            
            // HAPUS semua data static dari config.js
            console.log('🗑️  Removing static data from config.js...');
            
            // REPLACE dengan data database
            bookingApp.servicesData = DATA_TRANSPORTASI_FROM_DB;
            console.log('✅ bookingApp.servicesData = DATABASE (100% from MySQL)');
            
            // VERIFY data source
            console.log('� Verifying data source:');
            console.log('   - Pesawat items:', bookingApp.servicesData.pesawat.length);
            console.log('   - Kapal items:', bookingApp.servicesData.kapal.length);
            console.log('   - Bus items:', bookingApp.servicesData.bus.length);
            
            // Clear & re-render dengan data database
            console.log('🔄 Clearing old cards and rendering DATABASE data...');
            
            const container = document.getElementById('cardsContainer');
            if (container) {
                container.innerHTML = '<div style="text-align:center;padding:40px;"><h3 style="color:#667eea;">⏳ Loading Data dari Database...</h3><p style="color:#999;">Mengambil data terbaru dari MySQL...</p></div>';
            }
            
            // Re-render dengan delay untuk memastikan clean state
            setTimeout(() => {
                console.log('🎨 Rendering cards from DATABASE...');
                
                // RENDER dengan data database
                bookingApp.renderCards(bookingApp.currentFilter);
                
                console.log('✅ Cards rendered successfully!');
                console.log('📋 Total cards displayed:', document.querySelectorAll('.service-card').length);
                
                // Update badge counts dari database
                document.getElementById('badge-pesawat').textContent = DATA_TRANSPORTASI_FROM_DB.pesawat.length;
                document.getElementById('badge-kapal').textContent = DATA_TRANSPORTASI_FROM_DB.kapal.length;
                document.getElementById('badge-bus').textContent = DATA_TRANSPORTASI_FROM_DB.bus.length;
                
                console.log('✅ Badge counts updated from DATABASE');
                console.log('═══════════════════════════════════════════════════');
                console.log('🎉 SUCCESS! All data loaded from DATABASE');
                console.log('📅 Last update:', DB_DATE);
                console.log('═══════════════════════════════════════════════════');
                console.log('💡 TEST SEKARANG:');
                console.log('   1. Edit data di Admin Panel');
                console.log('   2. Refresh halaman ini (Ctrl+F5)');
                console.log('   3. Perubahan LANGSUNG terlihat! ✅');
                console.log('═══════════════════════════════════════════════════');
                
            }, 100);
        } else {
            console.error('═══════════════════════════════════════════════════');
            console.error('❌ ERROR: bookingApp or DATABASE data not found!');
            console.error('═══════════════════════════════════════════════════');
            console.log('Debug info:', {
                bookingApp: typeof bookingApp,
                DATA_TRANSPORTASI_FROM_DB: typeof DATA_TRANSPORTASI_FROM_DB,
                hasData: DATA_TRANSPORTASI_FROM_DB ? 'YES' : 'NO'
            });
            console.error('═══════════════════════════════════════════════════');
        }
    </script>
</body>
</html>

