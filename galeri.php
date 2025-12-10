<?php
/**
 * HALAMAN GALERI - CV. CENDANA TRAVEL
 */

// ✅ Load page configuration
require_once 'includes/page_config.php';

// ✅ Anti-cache headers
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

// ✅ Load data galeri dari database
$galleries = getAllGallery();

// ✅ Fix image path - tambahkan "uploads/" prefix jika belum ada
foreach ($galleries as &$gallery) {
    if (!empty($gallery['image'])) {
        if (strpos($gallery['image'], 'uploads/') !== 0) {
            $gallery['image'] = 'uploads/' . $gallery['image'];
        }
    }
}
unset($gallery); // Break reference

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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - <?php echo htmlspecialchars($companyName); ?></title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="galeri-modern.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="icons.css">
    
    <!-- Critical CSS untuk memastikan pagination style tampil -->
    <style>
        /* Force display dengan !important */
        .gallery-pagination {
            display: block !important;
            max-width: 700px !important;
            margin: 4rem auto 3rem !important;
            padding: 2.5rem 2rem !important;
            background: linear-gradient(135deg, #FFF8F3 0%, #FFFFFF 100%) !important;
            border-radius: 16px !important;
            border: 1px solid #E8BBA8 !important;
            box-shadow: 0 4px 16px rgba(212, 149, 110, 0.12) !important;
        }
        
        .progress-bar {
            height: 10px !important;
            background: #F3E8E0 !important;
            border-radius: 100px !important;
            margin-bottom: 1.25rem !important;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #D4956E 0%, #E8A87A 50%, #D4956E 100%) !important;
            border-radius: 100px !important;
            transition: width 0.6s ease !important;
        }
        
        .progress-text {
            text-align: center;
            color: #6B7280 !important;
            font-size: 1rem !important;
            margin-bottom: 2rem !important;
        }
        
        .progress-text strong {
            color: #D4956E !important;
            font-weight: 700;
        }
        
        .btn-load-more {
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            max-width: 350px;
            margin: 0 auto !important;
            padding: 18px 36px !important;
            background: linear-gradient(135deg, #D4956E 0%, #B8704D 100%) !important;
            border: 2px solid #D4956E !important;
            border-radius: 14px !important;
            font-size: 1.05rem !important;
            font-weight: 700;
            color: #FFFFFF !important;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(212, 149, 110, 0.35), 0 2px 6px rgba(0, 0, 0, 0.1) !important;
        }
        
        .btn-load-more:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, #E8A87A 0%, #D4956E 100%) !important;
        }
        
        /* Completed message - simple text only */
        .gallery-completed {
            display: block !important;
            text-align: center;
            padding: 0 !important;
            margin: 3rem auto 2rem !important;
        }
        
        .completed-text {
            color: #6B7280;
            font-size: 0.95rem;
            margin: 0;
        }
    </style>
</head>
<body class="page-galeri">
    <!-- Header Navigation -->
    <header>
        <div class="container header-container">
            <a href="index.php" class="logo"><?php echo htmlspecialchars($companyName); ?></a>
            
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="pemesanan.php">Pemesanan</a></li>
                    <li><a href="galeri.php" class="active">Galeri</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                </ul>
            </nav>
            
            <div class="header-controls">
                <a href="https://wa.me/<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>" class="wa-header-btn" target="_blank" title="Hubungi via WhatsApp">
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
    <section class="page-hero-standard" id="home" <?php if (!empty($homepageSettings['galeri_hero_background'])): ?>style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('uploads/<?php echo htmlspecialchars($homepageSettings['galeri_hero_background']); ?>'); background-size: cover; background-position: center;"<?php endif; ?>>
        <div class="container">
            <div class="page-hero-content">
                <h1 class="page-hero-title">
                    <?php echo htmlspecialchars($homepageSettings['galeri_hero_title'] ?? 'Galeri Perjalanan'); ?>
                </h1>
                <p class="page-hero-subtitle">
                    <?php echo htmlspecialchars($homepageSettings['galeri_hero_description'] ?? 'Koleksi momen indah dari perjalanan pelanggan kami ke berbagai destinasi menakjubkan'); ?>
                </p>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section">
        <div class="container">
            <div class="section-header">
                <h2>Koleksi Foto & Video</h2>
                <p>Jelajahi momen-momen istimewa dari perjalanan bersama kami</p>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs" style="margin-bottom: var(--spacing-2xl);">
                <button class="filter-tab active" data-filter="all" onclick="filterGallery('all')">
                    <i class="icon icon-th"></i>
                    Semua
                </button>
                <button class="filter-tab" data-filter="kantor" onclick="filterGallery('kantor')">
                    <i class="icon icon-building"></i>
                    Kantor
                </button>
                <button class="filter-tab" data-filter="fasilitas" onclick="filterGallery('fasilitas')">
                    <i class="icon icon-star"></i>
                    Fasilitas
                </button>
                <button class="filter-tab" data-filter="layanan" onclick="filterGallery('layanan')">
                    <i class="icon icon-heart"></i>
                    Layanan
                </button>
            </div>

            <!-- Gallery Masonry Grid -->
            <div class="gallery-masonry-grid" id="galleryGrid">
                <!-- Photos will be rendered by JavaScript -->
            </div>
            
            <!-- Pagination Controls - Minimal Design -->
            <div class="gallery-load-more" id="galleryPagination" style="display: none;">
                <p class="load-more-text" id="progressText">Menampilkan <strong>9</strong> dari <strong>24</strong> foto</p>
                <button class="btn-load-more" id="loadMoreBtn" onclick="loadMorePhotos()">
                    <span class="btn-text">Muat Foto Lagi</span>
                </button>
            </div>
            
            <!-- All Photos Loaded Message - Simple -->
            <div class="gallery-completed" id="galleryCompleted" style="display: none;">
                <p class="completed-text">Semua foto telah ditampilkan.</p>
            </div>
            
            <!-- Hidden PHP Data for JavaScript -->
            <script id="galleryData" type="application/json">
                <?php echo json_encode($galleries); ?>
            </script>
</section>

<!-- Lightbox Modal dengan Navigation -->
<div id="lightbox-modal" class="lightbox-modal">
    <div class="lightbox-content">
        <!-- Header -->
        <div class="lightbox-header">
            <h2 class="lightbox-title" id="lightbox-title">Detail Foto</h2>
            <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
        </div>
        
        <!-- Body dengan Navigation -->
        <div class="lightbox-body">
            <!-- Previous Button -->
            <button class="lightbox-nav lightbox-prev" onclick="navigateLightbox(-1)" title="Foto Sebelumnya">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            
            <!-- Image Container -->
            <div class="lightbox-image-container">
                <img id="lightbox-image" src="" alt="">
            </div>
            
            <!-- Next Button -->
            <button class="lightbox-nav lightbox-next" onclick="navigateLightbox(1)" title="Foto Selanjutnya">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>
        
        <!-- Caption -->
        <div id="lightbox-caption" class="lightbox-caption">
            <div class="lightbox-caption-title" id="lightbox-caption-title"></div>
            <div class="lightbox-caption-desc" id="lightbox-caption-desc"></div>
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

    <script>
        // ===== GALLERY DATA & PAGINATION =====
        let allGalleryData = [];
        let currentFilter = 'all';
        let displayedCount = 0;
        const PHOTOS_PER_BATCH = 9;
        
        // Load gallery data from PHP
        function loadGalleryData() {
            const dataScript = document.getElementById('galleryData');
            if (dataScript) {
                allGalleryData = JSON.parse(dataScript.textContent);
                console.log('Loaded gallery data:', allGalleryData.length, 'photos');
                
                // Initial render - first 9 photos
                displayedCount = 0;
                renderGallery(true);
            }
        }
        
        // Render gallery photos
        function renderGallery(reset = false) {
            const grid = document.getElementById('galleryGrid');
            
            if (reset) {
                grid.innerHTML = '';
                displayedCount = 0;
            }
            
            // Filter photos based on current filter
            const filteredPhotos = currentFilter === 'all' 
                ? allGalleryData 
                : allGalleryData.filter(photo => {
                    const category = (photo.category || 'all').toLowerCase();
                    return category === currentFilter;
                });
            
            // Get next batch of photos
            const startIndex = displayedCount;
            const endIndex = Math.min(startIndex + PHOTOS_PER_BATCH, filteredPhotos.length);
            const photosToShow = filteredPhotos.slice(startIndex, endIndex);
            
            // Render photos
            if (filteredPhotos.length === 0) {
                grid.innerHTML = `
                    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                        <i class="icon icon-image" style="font-size: 4rem; color: var(--color-light-gray); margin-bottom: 1rem;"></i>
                        <p style="color: var(--color-gray); font-size: 1.1rem;">Tidak ada foto di kategori ini</p>
                        <p style="color: var(--color-light-gray); font-size: 0.9rem;">Pilih kategori lain atau lihat semua foto</p>
                    </div>
                `;
                document.getElementById('galleryPagination').style.display = 'none';
                document.getElementById('galleryCompleted').style.display = 'none';
                return;
            }
            
            photosToShow.forEach((photo, index) => {
                const article = document.createElement('article');
                article.className = 'gallery-item showing';
                article.dataset.category = (photo.category || 'all').toLowerCase();
                
                const imgSrc = photo.image;
                const title = photo.title || 'Foto Galeri';
                const description = photo.description || '';
                
                article.innerHTML = `
                    <img src="${imgSrc}" 
                         alt="${title}"
                         loading="lazy"
                         onerror="this.src='https://via.placeholder.com/500x300?text=Image+Not+Found'">
                    <div class="gallery-overlay">
                        <div class="gallery-overlay-content">
                            <h3>${title}</h3>
                            ${description ? `<p>${description.substring(0, 80)}${description.length > 80 ? '...' : ''}</p>` : ''}
                        </div>
                    </div>
                `;
                
                article.onclick = () => {
                    openLightbox(imgSrc, title, description);
                };
                
                // Stagger animation
                setTimeout(() => {
                    article.classList.remove('showing');
                }, 500);
                
                grid.appendChild(article);
            });
            
            // Update displayed count
            displayedCount = endIndex;
            
            // Update Load More button visibility
            updateLoadMoreButton(filteredPhotos.length);
        }
        
        // Update Load More button
        function updateLoadMoreButton(totalFilteredPhotos) {
            const paginationSection = document.getElementById('galleryPagination');
            const completedSection = document.getElementById('galleryCompleted');
            const progressText = document.getElementById('progressText');
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            
            if (displayedCount < totalFilteredPhotos) {
                // More photos available - show load more
                paginationSection.style.display = 'block';
                completedSection.style.display = 'none';
                
                // Update text
                progressText.innerHTML = `Menampilkan <strong>${displayedCount}</strong> dari <strong>${totalFilteredPhotos}</strong> foto`;
                
                // Update button state
                loadMoreBtn.disabled = false;
                loadMoreBtn.querySelector('.btn-text').textContent = 'Muat Foto Lagi';
                
            } else if (totalFilteredPhotos > 0) {
                // All photos shown - show completion message
                paginationSection.style.display = 'none';
                completedSection.style.display = 'block';
                
            } else {
                // No photos
                paginationSection.style.display = 'none';
                completedSection.style.display = 'none';
            }
        }
        
        // Load more photos
        function loadMorePhotos() {
            renderGallery(false);
        }
        
        // ===== FILTER GALLERY - SMOOTH ANIMATIONS =====
        function filterGallery(category) {
            const tabs = document.querySelectorAll('.filter-tab');
            
            // Update active tab
            tabs.forEach(tab => tab.classList.remove('active'));
            event.target.closest('.filter-tab').classList.add('active');
            
            // Update current filter
            currentFilter = category;
            
            // Re-render gallery with new filter
            renderGallery(true);
        }
        
        // ===== LIGHTBOX MODAL WITH NAVIGATION =====
        let currentPhotoIndex = 0;
        let allPhotos = [];
        
        // Function to collect all visible photos
        function collectPhotos() {
            const galleryItems = document.querySelectorAll('.gallery-item');
            allPhotos = Array.from(galleryItems)
                .filter(item => item.style.display !== 'none')
                .map(item => {
                    const img = item.querySelector('img');
                    const titleEl = item.querySelector('.gallery-overlay-content h3');
                    const descEl = item.querySelector('.gallery-overlay-content p');
                    
                    return {
                        image: img ? img.src : '',
                        title: titleEl ? titleEl.textContent : 'Foto Galeri',
                        description: descEl ? descEl.textContent : ''
                    };
                })
                .filter(photo => photo.image); // Only photos with valid images
            
            console.log('Photos collected:', allPhotos.length);
        }
        
        // Collect photos when page loads
        document.addEventListener('DOMContentLoaded', function() {
            collectPhotos();
        });
        
        function openLightbox(imageSrc, title, description) {
            // Recollect photos (in case filter changed)
            collectPhotos();
            
            const modal = document.getElementById('lightbox-modal');
            const image = document.getElementById('lightbox-image');
            const titleEl = document.getElementById('lightbox-caption-title');
            const descEl = document.getElementById('lightbox-caption-desc');
            
            // Find current photo index
            currentPhotoIndex = allPhotos.findIndex(photo => photo.image === imageSrc);
            if (currentPhotoIndex === -1) currentPhotoIndex = 0;
            
            console.log('Opening lightbox, index:', currentPhotoIndex, 'of', allPhotos.length);
            
            // Set image
            image.src = imageSrc;
            image.alt = title;
            
            // Set title
            if (titleEl) {
                titleEl.textContent = title || 'Foto Galeri';
            }
            
            // Set description
            if (descEl) {
                if (description && description.trim()) {
                    descEl.textContent = description;
                    descEl.classList.remove('lightbox-caption-empty');
                } else {
                    descEl.textContent = 'Tidak ada deskripsi';
                    descEl.classList.add('lightbox-caption-empty');
                }
            }
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Update nav button visibility
            updateNavButtons();
        }
        
        function navigateLightbox(direction) {
            if (allPhotos.length === 0) {
                console.log('No photos available');
                return;
            }
            
            currentPhotoIndex += direction;
            
            // Loop around
            if (currentPhotoIndex < 0) {
                currentPhotoIndex = allPhotos.length - 1;
            } else if (currentPhotoIndex >= allPhotos.length) {
                currentPhotoIndex = 0;
            }
            
            console.log('Navigate to index:', currentPhotoIndex);
            
            const photo = allPhotos[currentPhotoIndex];
            if (photo && photo.image) {
                // Update modal content directly
                const image = document.getElementById('lightbox-image');
                const titleEl = document.getElementById('lightbox-caption-title');
                const descEl = document.getElementById('lightbox-caption-desc');
                
                image.src = photo.image;
                image.alt = photo.title;
                
                if (titleEl) titleEl.textContent = photo.title;
                
                if (descEl) {
                    if (photo.description && photo.description.trim()) {
                        descEl.textContent = photo.description;
                        descEl.classList.remove('lightbox-caption-empty');
                    } else {
                        descEl.textContent = 'Tidak ada deskripsi';
                        descEl.classList.add('lightbox-caption-empty');
                    }
                }
            }
        }
        
        function updateNavButtons() {
            const prevBtn = document.querySelector('.lightbox-prev');
            const nextBtn = document.querySelector('.lightbox-next');
            
            if (allPhotos.length <= 1) {
                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'none';
            } else {
                if (prevBtn) prevBtn.style.display = 'flex';
                if (nextBtn) nextBtn.style.display = 'flex';
            }
        }
        
        function closeLightbox() {
            const modal = document.getElementById('lightbox-modal');
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
        
        // Close lightbox on ESC key, navigate with arrow keys
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('lightbox-modal');
            if (!modal.classList.contains('active')) return;
            
            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowLeft') {
                navigateLightbox(-1);
            } else if (e.key === 'ArrowRight') {
                navigateLightbox(1);
            }
        });
        
        // Close lightbox on background click
        document.getElementById('lightbox-modal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });
        
        // Initialize gallery on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadGalleryData();
            
            // Lazy loading images
            const galleryGrid = document.getElementById('galleryGrid');
            galleryGrid.addEventListener('load', function(e) {
                if (e.target.tagName === 'IMG') {
                    e.target.classList.add('loaded');
                }
            }, true);
        });
    </script>
    <script src="config.js"></script>
    <script src="script.js"></script>
</body>
</html>
