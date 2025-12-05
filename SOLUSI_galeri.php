<?php
/**
 * SOLUSI: Halaman Galeri - Dengan Data dari Database
 * File: galeri.php (VERSI PERBAIKAN)
 * 
 * PERUBAHAN UTAMA:
 * 1. ✅ Menambahkan koneksi database
 * 2. ✅ Mengambil data gallery dari database
 * 3. ✅ Render galeri dari database (bukan hardcoded)
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
        'hours' => 'Senin - Minggu: 08.00 - 22.00 WIB',
        'description' => 'Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda.'
    ];
}

// Ambil semua data gallery dari database
$galleries = getAllGallery();

// Fallback jika database kosong - gunakan data dummy
if (empty($galleries)) {
    $galleries = [
        [
            'id' => 1,
            'title' => 'Kantor Pusat Kami',
            'description' => 'Lokasi strategis di Samarinda',
            'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=500',
            'category' => 'kantor',
            'is_active' => 1,
            'is_featured' => 1
        ],
        [
            'id' => 2,
            'title' => 'Area Tunggu Nyaman',
            'description' => 'Fasilitas lengkap dengan AC',
            'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=500',
            'category' => 'fasilitas',
            'is_active' => 1,
            'is_featured' => 1
        ],
        [
            'id' => 3,
            'title' => 'Tim Profesional',
            'description' => 'Siap melayani Anda',
            'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=500',
            'category' => 'layanan',
            'is_active' => 1,
            'is_featured' => 0
        ]
    ];
}

// Hitung jumlah per kategori
$galleryStats = [
    'all' => 0,
    'kantor' => 0,
    'fasilitas' => 0,
    'layanan' => 0
];

foreach ($galleries as $gallery) {
    if ($gallery['is_active'] == 1) {
        $galleryStats['all']++;
        $category = strtolower($gallery['category']);
        if (isset($galleryStats[$category])) {
            $galleryStats[$category]++;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - <?php echo htmlspecialchars($companyInfo['name']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="icons.css">
</head>
<body class="page-galeri">
    <!-- Header Navigation -->
    <header>
        <div class="container header-container">
            <a href="index.php" class="logo"><?php echo htmlspecialchars($companyInfo['name']); ?></a>
            
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="pemesanan.php">Pemesanan</a></li>
                    <li><a href="galeri.php" class="active">Galeri</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                </ul>
            </nav>
            
            <div class="header-controls">
                <a href="https://wa.me/<?php echo htmlspecialchars($companyInfo['whatsapp']); ?>" class="wa-header-btn" target="_blank" title="Hubungi via WhatsApp">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" class="wa-icon">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>
                    </svg>
                    <span>WhatsApp</span>
                </a>
                <div class="mobile-menu" title="Menu">
                    <i class="icon icon-menu"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home" style="min-height: 500px; margin-top: 70px;">
        <div class="hero-overlay">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title" style="font-size: 3rem;">
                        Galeri Perjalanan
                    </h1>
                    <p class="hero-description">
                        Koleksi momen indah dari perjalanan pelanggan kami ke berbagai destinasi menakjubkan. Lihat pengalaman nyata dan fasilitas yang kami tawarkan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section">
        <div class="container">
            <div class="section-header">
                <h2>Koleksi Foto & Video</h2>
                <p>Jelajahi momen-momen istimewa dari perjalanan bersama kami (<?php echo $galleryStats['all']; ?> foto)</p>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs" style="margin-bottom: var(--spacing-2xl);">
                <button class="filter-tab active" data-filter="all" onclick="filterGallery('all')">
                    <i class="icon icon-th"></i>
                    Semua (<?php echo $galleryStats['all']; ?>)
                </button>
                <button class="filter-tab" data-filter="kantor" onclick="filterGallery('kantor')">
                    <i class="icon icon-building"></i>
                    Kantor (<?php echo $galleryStats['kantor']; ?>)
                </button>
                <button class="filter-tab" data-filter="fasilitas" onclick="filterGallery('fasilitas')">
                    <i class="icon icon-star"></i>
                    Fasilitas (<?php echo $galleryStats['fasilitas']; ?>)
                </button>
                <button class="filter-tab" data-filter="layanan" onclick="filterGallery('layanan')">
                    <i class="icon icon-heart"></i>
                    Layanan (<?php echo $galleryStats['layanan']; ?>)
                </button>
            </div>

            <!-- Gallery Grid - DATA DARI DATABASE -->
            <div class="gallery-grid">
                <?php 
                if (!empty($galleries) && count($galleries) > 0):
                    foreach ($galleries as $gallery): 
                        // Hanya tampilkan yang aktif
                        if ($gallery['is_active'] != 1) continue;
                        
                        $category = strtolower($gallery['category']);
                        $imageUrl = !empty($gallery['image']) ? htmlspecialchars($gallery['image']) : 'uploads/gallery/default.jpg';
                        $title = htmlspecialchars($gallery['title']);
                        $description = htmlspecialchars($gallery['description']);
                        $isFeatured = $gallery['is_featured'] == 1 ? 'featured' : '';
                ?>
                <!-- Gallery Item dari Database -->
                <article class="gallery-item <?php echo $isFeatured; ?>" data-category="<?php echo $category; ?>">
                    <img src="<?php echo $imageUrl; ?>" alt="<?php echo $title; ?>" loading="lazy">
                    <div class="gallery-overlay">
                        <div class="gallery-overlay-content">
                            <h3><?php echo $title; ?></h3>
                            <?php if (!empty($description)): ?>
                            <p><?php echo $description; ?></p>
                            <?php endif; ?>
                            <?php if ($gallery['is_featured'] == 1): ?>
                            <span class="featured-badge">⭐ Featured</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php 
                    endforeach;
                else: 
                ?>
                <!-- Pesan jika tidak ada data -->
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                    <div style="font-size: 64px; margin-bottom: 20px;">📷</div>
                    <h3 style="margin-bottom: 10px; color: var(--color-text);">Belum Ada Galeri</h3>
                    <p style="color: var(--color-text-muted);">Galeri foto akan segera ditambahkan. Silakan kembali lagi nanti.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="background: var(--color-primary); color: white; padding: var(--spacing-3xl) 0;">
        <div class="container" style="text-align: center;">
            <h2 style="color: white; margin-bottom: var(--spacing-lg);">Ingin Melihat Lebih Banyak?</h2>
            <p style="color: rgba(255, 255, 255, 0.9); margin-bottom: var(--spacing-2xl); font-size: 1.1rem;">
                Ikuti media sosial kami untuk update terbaru dan promosi menarik
            </p>
            <div style="display: flex; gap: var(--spacing-lg); justify-content: center; flex-wrap: wrap;">
                <?php if (!empty($companyInfo['instagram'])): ?>
                <a href="https://instagram.com/<?php echo str_replace('@', '', htmlspecialchars($companyInfo['instagram'])); ?>" class="btn-hero btn-hero-primary" target="_blank">
                    <i class="icon icon-camera"></i> Follow Instagram
                </a>
                <?php endif; ?>
                <a href="pemesanan.php" class="btn-hero" style="background: rgba(255, 255, 255, 0.2); border: 2px solid white; color: white;">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Footer Premium -->
    <footer class="footer-premium">
        <div class="container">
            <!-- Main Grid: 4 Kolom -->
            <div class="footer-grid-premium">
                
                <!-- KOLOM 1: Tentang Kami -->
                <section class="footer-section-premium">
                    <h3 class="footer-heading-premium">Tentang Kami</h3>
                    <div class="footer-separator-premium"></div>
                    <p class="footer-text-premium">
                        <?php echo htmlspecialchars($companyInfo['description']); ?>
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
    <script src="galeri.js"></script>
    <script src="script.js"></script>
</body>
</html>
