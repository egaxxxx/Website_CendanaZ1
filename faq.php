<?php
require_once 'includes/page_config.php';
require_once 'includes/faq_data.php';

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

$faqData = getFaqData();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - <?php echo htmlspecialchars($companyName); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="icons.css">
</head>
<body class="page-faq">
    <!-- Header Navigation -->
    <header>
        <div class="container header-container">
            <a href="index.php" class="logo"><?php echo htmlspecialchars($companyName); ?></a>
            
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="pemesanan.php">Pemesanan</a></li>
                    <li><a href="galeri.php">Galeri</a></li>
                    <li><a href="faq.php" class="active">FAQ</a></li>
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
    <section class="hero" id="home" style="min-height: 500px; margin-top: 70px;" <?php if (!empty($homepageSettings['faq_hero_background'])): ?>style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('uploads/<?php echo htmlspecialchars($homepageSettings['faq_hero_background']); ?>'); background-size: cover; background-position: center; min-height: 500px; margin-top: 70px;"<?php endif; ?>>
        <div class="hero-overlay">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title" style="font-size: 3rem;">
                        <?php echo htmlspecialchars($homepageSettings['faq_hero_title'] ?? 'Pusat Bantuan & FAQ'); ?>
                    </h1>
                    <p class="hero-description">
                        <?php echo htmlspecialchars($homepageSettings['faq_hero_description'] ?? 'Jawaban lengkap untuk semua pertanyaan seputar layanan perjalanan kami. Temukan informasi yang Anda butuhkan.'); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <!-- FAQ Tabs/Categories -->
            <div class="filter-tabs" style="margin-bottom: var(--spacing-2xl);">
                <?php foreach ($faqData as $index => $category): ?>
                    <button class="filter-tab <?php echo $index === 0 ? 'active' : ''; ?>" 
                            onclick="switchFaqCategory(<?php echo $index; ?>)"
                            data-category="<?php echo htmlspecialchars($category['category']); ?>">
                        <?php echo htmlspecialchars($category['category']); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- FAQ Items Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: var(--spacing-lg);">
                <?php foreach ($faqData as $categoryIndex => $category): ?>
                    <div class="faq-category-group" data-category-index="<?php echo $categoryIndex; ?>" 
                         style="<?php echo $categoryIndex !== 0 ? 'display: none;' : ''; ?> grid-column: 1 / -1;">
                        <?php foreach ($category['items'] as $itemIndex => $item): ?>
                            <div class="faq-item">
                                <button class="faq-item-header" onclick="toggleFaqItem(this)">
                                    <span><?php echo htmlspecialchars($item['question']); ?></span>
                                    <i class="icon icon-chevron-down faq-item-icon"></i>
                                </button>
                                <div class="faq-item-content">
                                    <p><?php echo $item['answer']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Support Section -->
    <section style="background: var(--color-light-gray); padding: var(--spacing-3xl) 0;">
        <div class="container">
            <div class="section-header">
                <h2>Masih Punya Pertanyaan?</h2>
                <p>Hubungi tim customer service kami yang siap membantu Anda 24/7</p>
            </div>

            <div class="services-grid">
                <article class="service-card">
                    <div class="service-icon">
                        <i class="icon icon-whatsapp"></i>
                    </div>
                    <h3>Chat WhatsApp</h3>
                    <p>Hubungi kami melalui WhatsApp untuk respons cepat dan konsultasi langsung.</p>
                    <a href="https://wa.me/<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>" class="btn-book-now" target="_blank">
                        Hubungi Sekarang
                    </a>
                </article>
                
                <article class="service-card">
                    <div class="service-icon">
                        <i class="icon icon-email"></i>
                    </div>
                    <h3>Kirim Email</h3>
                    <p>Kirim pertanyaan detail Anda melalui email dan kami akan merespons segera.</p>
                    <a href="kontak.php" class="btn-book-now">
                        Kirim Pesan
                    </a>
                </article>
                
                <article class="service-card">
                    <div class="service-icon">
                        <i class="icon icon-phone"></i>
                    </div>
                    <h3>Kunjungi Kantor</h3>
                    <p>Datang ke kantor kami untuk konsultasi langsung dengan tim profesional kami.</p>
                    <a href="kontak.php" class="btn-book-now">
                        Lihat Lokasi
                    </a>
                </article>
            </div>
        </div>
    </section>

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
                                Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunang, Kota Samarinda, Kalimantan Timur 75127
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
        function toggleFaqItem(button) {
            const item = button.parentElement;
            const allItems = document.querySelectorAll('.faq-item');
            
            allItems.forEach(el => {
                if (el !== item && el.classList.contains('active')) {
                    el.classList.remove('active');
                }
            });
            
            item.classList.toggle('active');
        }

        function switchFaqCategory(categoryIndex) {
            // Hide all categories
            const categories = document.querySelectorAll('.faq-category-group');
            categories.forEach(cat => cat.style.display = 'none');
            
            // Show selected category
            const selectedCategory = document.querySelector(`[data-category-index="${categoryIndex}"]`);
            if (selectedCategory) {
                selectedCategory.style.display = 'block';
                selectedCategory.style.gridColumn = '1 / -1';
            }
            
            // Update active tab
            const tabs = document.querySelectorAll('.filter-tab');
            tabs.forEach((tab, index) => {
                tab.classList.toggle('active', index === categoryIndex);
            });
            
            // Close all FAQ items
            document.querySelectorAll('.faq-item').forEach(item => {
                item.classList.remove('active');
            });
        }
    </script>
    <script src="config.js"></script>
    <script src="script.js"></script>
</body>
</html>

<?php
if (isset($conn)) {
    $conn->close();
}
?>
