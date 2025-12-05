<?php
/**
 * ============================================
 * HALAMAN GALERI - CV. CENDANA TRAVEL
 * ============================================
 */

// Data default tanpa database untuk menghindari error
$companyInfoData = [
    'name' => 'CV. Cendana Travel',
    'whatsapp' => '6285821841529',
    'instagram' => '@cendanatravel_official',
    'email' => 'info@cendanatravel.com',
    'address' => 'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang<br>Kota Samarinda, Kalimantan Timur 75127',
    'hours' => 'Senin - Minggu: 08.00 - 22.00 WIB',
    'description' => 'Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda.'
];

// Data galeri akan dimuat dari config.js
$dataFasilitas = [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - <?php echo htmlspecialchars($companyInfoData['name']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="icons.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <!-- Logo Perusahaan -->
            <a href="index.php" class="logo"><?php echo htmlspecialchars($companyInfoData['name']); ?></a>
            
            <!-- Menu Navigasi -->
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="pemesanan.php">Pemesanan</a></li>
                    <li><a href="galeri.php" class="active">Galeri</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                    <li><a href="faq.php">FAQ</a></li>
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
    <section class="gallery-hero">
        <div class="container">
            <div class="gallery-hero-content">
                <h1 class="gallery-hero-title">Galeri Perjalanan</h1>
                <p class="gallery-hero-subtitle">Koleksi momen indah dari perjalanan pelanggan kami ke berbagai destinasi menakjubkan. Lihat pengalaman nyata dan fasilitas yang kami tawarkan.</p>
            </div>
        </div>
        
        <!-- Decorative Background Elements -->
        <div class="hero-decoration">
            <div class="decoration-circle circle-1"></div>
            <div class="decoration-circle circle-2"></div>
            <div class="decoration-circle circle-3"></div>
        </div>
    </section>

    <!-- Galeri Grid -->
    <section class="gallery-section">
        <div class="container">
            <!-- Filter Tabs -->
            <div class="gallery-filter-tabs">
                <button class="filter-tab active" data-category="all" onclick="filterGallery('all')">
                    <i class="icon icon-th"></i>
                    Semua Foto
                </button>
                <button class="filter-tab" data-category="kantor" onclick="filterGallery('kantor')">
                    <i class="icon icon-building"></i>
                    Kantor & Fasilitas
                </button>
                <button class="filter-tab" data-category="layanan" onclick="filterGallery('layanan')">
                    <i class="icon icon-star"></i>
                    Layanan
                </button>
                <button class="filter-tab" data-category="sistem" onclick="filterGallery('sistem')">
                    <i class="icon icon-cog"></i>
                    Sistem & Teknologi
                </button>
            </div>

            <!-- Gallery Stats -->
            <div class="gallery-stats">
                <div class="stat-item">
                    <span class="stat-number" id="gallery-count">7</span>
                    <span class="stat-label">Total Foto</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">1000+</span>
                    <span class="stat-label">Perjalanan Sukses</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">⭐ 4.8</span>
                    <span class="stat-label">Rating Pelanggan</span>
                </div>
            </div>

            <div class="gallery-grid" id="gallery-grid">
                <!-- Foto galeri akan dimuat di sini menggunakan JavaScript -->
            </div>
        </div>
    </section>

    <!-- Modal Popup Gambar -->
    <div class="gallery-modal-overlay" id="galleryModal">
        <div class="gallery-modal">
            <button class="gallery-modal-close" onclick="tutupModalGaleri()">
                <i class="icon icon-times"></i>
            </button>
            
            <!-- Navigation Arrows -->
            <button class="gallery-modal-nav gallery-modal-prev" onclick="navigateGallery(-1)">
                <i class="icon icon-chevron-left"></i>
            </button>
            <button class="gallery-modal-nav gallery-modal-next" onclick="navigateGallery(1)">
                <i class="icon icon-chevron-right"></i>
            </button>
            
            <div class="gallery-modal-image">
                <img id="gallery-modal-img" src="" alt="Galeri">
            </div>
            <div class="gallery-modal-info">
                <div class="gallery-modal-header">
                    <div class="modal-title-group">
                        <h3 id="gallery-modal-title"></h3>
                        <span class="gallery-modal-counter" id="gallery-modal-counter">1 / 7</span>
                    </div>
                </div>
                
                <!-- Metadata Info -->
                <div class="gallery-modal-metadata">
                    <div class="metadata-item">
                        <i class="icon icon-calendar"></i>
                        <div class="metadata-content">
                            <span class="metadata-label">Tanggal Upload</span>
                            <span class="metadata-value" id="gallery-modal-date">28 Oktober 2024</span>
                        </div>
                    </div>
                    <div class="metadata-item">
                        <i class="icon icon-map-marker"></i>
                        <div class="metadata-content">
                            <span class="metadata-label">Lokasi</span>
                            <span class="metadata-value" id="gallery-modal-location">Kantor Pusat</span>
                        </div>
                    </div>
                    <div class="metadata-item">
                        <i class="icon icon-tag"></i>
                        <div class="metadata-content">
                            <span class="metadata-label">Kategori</span>
                            <span class="metadata-value" id="gallery-modal-category">Fasilitas</span>
                        </div>
                    </div>
                </div>
                
                <p class="gallery-modal-description" id="gallery-modal-description"></p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php echo htmlspecialchars($companyInfoData['name']); ?></h3>
                    <p><?php echo htmlspecialchars($companyInfoData['description']); ?></p>
                </div>
                <div class="footer-section">
                    <h3>Menu</h3>
                    <ul>
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="pemesanan.php">Pemesanan</a></li>
                        <li><a href="galeri.php">Galeri</a></li>
                        <li><a href="kontak.php">Kontak</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Hubungi Kami</h3>
                    <p><i class="icon icon-whatsapp"></i> <?php echo htmlspecialchars($companyInfoData['whatsapp']); ?></p>
                    <p><i class="icon icon-email"></i> <?php echo htmlspecialchars($companyInfoData['email']); ?></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 <?php echo htmlspecialchars($companyInfoData['name']); ?>. All rights reserved.</p>
                <!-- Ikon kunci admin (tersembunyi) -->
                <div class="admin-access" onclick="showAdminLogin()" title="Akses Admin">
                    <i class="icon icon-sign-in"></i>
                </div>
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

    <!-- Load Config First -->
    <script src="config.js"></script>
    <script src="script.js"></script>
    
    <!-- Inline Galeri Script for Immediate Execution -->
    <script>
        console.log('=== INLINE GALERI SCRIPT START ===');
        
        // Check if config data exists
        if (typeof DATA_FASILITAS_DEFAULT === 'undefined') {
            console.error('ERROR: DATA_FASILITAS_DEFAULT not found!');
        } else {
            console.log('✓ DATA_FASILITAS_DEFAULT found:', DATA_FASILITAS_DEFAULT.length, 'items');
            
            // Wait for DOM to be ready
            function initGallery() {
                console.log('Initializing gallery...');
                const galleryGrid = document.getElementById('gallery-grid');
                
                if (!galleryGrid) {
                    console.error('ERROR: gallery-grid element not found!');
                    return;
                }
                
                console.log('✓ gallery-grid element found');
                
                if (DATA_FASILITAS_DEFAULT.length === 0) {
                    galleryGrid.innerHTML = '<div class="gallery-empty"><i class="icon icon-image"></i><p>Belum ada foto di galeri</p></div>';
                    return;
                }
                
                galleryGrid.innerHTML = '';
                
                DATA_FASILITAS_DEFAULT.forEach((item, index) => {
                    const imgPath = 'uploads/' + item.image;
                    console.log('Adding item ' + (index + 1) + ':', item.name, '|', imgPath);
                    
                    const galleryItem = document.createElement('div');
                    galleryItem.className = 'gallery-item';
                    galleryItem.setAttribute('data-category', item.category || 'all');
                    galleryItem.setAttribute('data-index', index);
                    galleryItem.style.animationDelay = (index * 0.1) + 's';
                    
                    galleryItem.innerHTML = `
                        <div class="gallery-image">
                            <img src="${imgPath}" alt="${item.name}" onload="console.log('✓ Image loaded: ${item.name}')" onerror="console.error('✗ Image failed: ${imgPath}')">
                            <div class="gallery-overlay">
                                <div class="gallery-overlay-content">
                                    <h3>${item.name}</h3>
                                    <button class="gallery-view-btn" onclick="openGalleryModal(${index})">
                                        <i class="icon icon-eye"></i>
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    galleryGrid.appendChild(galleryItem);
                });
                
                console.log('✓ Gallery items added:', DATA_FASILITAS_DEFAULT.length);
                updateGalleryCount();
            }
            
            // Current modal index
            let currentModalIndex = 0;
            
            // Format tanggal Indonesia
            function formatTanggalIndonesia(dateString) {
                const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                              'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                const date = new Date(dateString);
                return date.getDate() + ' ' + bulan[date.getMonth()] + ' ' + date.getFullYear();
            }
            
            // Get category name
            function getCategoryName(category) {
                const categories = {
                    'kantor': 'Kantor & Fasilitas',
                    'layanan': 'Layanan',
                    'sistem': 'Sistem & Teknologi'
                };
                return categories[category] || 'Umum';
            }
            
            // Gallery modal functions
            window.openGalleryModal = function(index) {
                currentModalIndex = index;
                const modal = document.getElementById('galleryModal');
                const item = DATA_FASILITAS_DEFAULT[index];
                
                if (!modal || !item) return;
                
                document.getElementById('gallery-modal-img').src = 'uploads/' + item.image;
                document.getElementById('gallery-modal-title').textContent = item.name;
                document.getElementById('gallery-modal-description').textContent = item.description;
                document.getElementById('gallery-modal-counter').textContent = (index + 1) + ' / ' + DATA_FASILITAS_DEFAULT.length;
                
                // Set metadata
                document.getElementById('gallery-modal-date').textContent = formatTanggalIndonesia(item.uploadDate || new Date().toISOString().split('T')[0]);
                document.getElementById('gallery-modal-location').textContent = item.location || 'Tidak disebutkan';
                document.getElementById('gallery-modal-category').textContent = getCategoryName(item.category);
                
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            };
            
            window.navigateGallery = function(direction) {
                currentModalIndex += direction;
                
                if (currentModalIndex < 0) currentModalIndex = DATA_FASILITAS_DEFAULT.length - 1;
                if (currentModalIndex >= DATA_FASILITAS_DEFAULT.length) currentModalIndex = 0;
                
                openGalleryModal(currentModalIndex);
            };
            
            window.tutupModalGaleri = function() {
                const modal = document.getElementById('galleryModal');
                if (modal) {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            };
            
            // Filter gallery function
            window.filterGallery = function(category) {
                const items = document.querySelectorAll('.gallery-item');
                const tabs = document.querySelectorAll('.filter-tab');
                
                // Update active tab
                tabs.forEach(tab => {
                    if (tab.getAttribute('data-category') === category) {
                        tab.classList.add('active');
                    } else {
                        tab.classList.remove('active');
                    }
                });
                
                // Filter items
                items.forEach(item => {
                    const itemCategory = item.getAttribute('data-category');
                    if (category === 'all' || itemCategory === category) {
                        item.style.display = 'block';
                        item.classList.add('fade-in');
                    } else {
                        item.style.display = 'none';
                        item.classList.remove('fade-in');
                    }
                });
                
                updateGalleryCount();
            };
            
            // Update gallery count
            function updateGalleryCount() {
                const visibleItems = document.querySelectorAll('.gallery-item[style*="display: block"], .gallery-item:not([style*="display: none"])');
                const countElement = document.getElementById('gallery-count');
                if (countElement) {
                    countElement.textContent = visibleItems.length;
                }
            }
            
            // Initialize when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initGallery);
            } else {
                initGallery();
            }
        }
        
        console.log('=== INLINE GALERI SCRIPT END ===');
    </script>
</body>
</html>

