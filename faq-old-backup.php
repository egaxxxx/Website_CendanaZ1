<?php
require_once 'config/database.php';
require_once 'includes/faq_data.php';

function getCompanyInfo($conn) {
    $company = [];
    $stmt = $conn->prepare("SELECT * FROM company_info WHERE id = 1");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $company = $result->fetch_assoc();
    }
    $stmt->close();
    return $company;
}

$companyInfoData = getCompanyInfo($conn);

if (empty($companyInfoData)) {
    $companyInfoData = [
        'name' => 'Cv. Cendana Travel',
        'whatsapp' => '6285821841529',
        'instagram' => '@cendanatravel_official',
        'email' => 'info@cendanatravel.com',
        'address' => 'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang<br>Kota Samarinda, Kalimantan Timur 75127',
        'hours' => 'Senin - Minggu: 08.00 - 22.00 WIB',
        'description' => 'Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda.'
    ];
}

// Get FAQ data from centralized source
$faqData = getFaqData();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - <?php echo htmlspecialchars($companyInfoData['name']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="icons.css">
</head>
<body>
    <header>
        <div class="container header-container">
            <!-- Logo Perusahaan -->
            <a href="index.php" class="logo"><?php echo htmlspecialchars($companyInfoData['name']); ?></a>
            
            <!-- Menu Navigasi -->
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="pemesanan.php">Pemesanan</a></li>
                    <li><a href="galeri.php">Galeri</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                    <li><a href="faq.php" class="active">FAQ</a></li>
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
    <section class="faq-hero">
        <div class="container">
            <div class="faq-hero-content">
                <h1 class="faq-hero-title">Pusat Bantuan & FAQ</h1>
                <p class="faq-hero-subtitle">Jawaban cepat untuk pertanyaan yang sering ditanyakan seputar layanan perjalanan Anda</p>
            </div>
        </div>
        
        <!-- Decorative Background Elements -->
        <div class="hero-decoration">
            <div class="decoration-circle circle-1"></div>
            <div class="decoration-circle circle-2"></div>
            <div class="decoration-circle circle-3"></div>
        </div>
    </section>

    <!-- Trust Section -->
    <section class="faq-trust-section">
        <div class="container">
            <div class="faq-trust-content">
                <div class="faq-trust-item">
                    <div class="faq-trust-icon">
                        <i class="icon icon-clock"></i>
                    </div>
                    <h3>Respon Cepat</h3>
                    <p>Dapatkan jawaban instan dari FAQ kami</p>
                </div>
                <div class="faq-trust-item">
                    <div class="faq-trust-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h3>Customer Support</h3>
                    <p>Tim siap membantu 24/7 via WhatsApp</p>
                </div>
                <div class="faq-trust-item">
                    <div class="faq-trust-icon">
                        <i class="icon icon-question-circle"></i>
                    </div>
                    <h3>Panduan Lengkap</h3>
                    <p>Informasi detail untuk semua layanan</p>
                </div>
                <div class="faq-trust-item">
                    <div class="faq-trust-icon">
                        <i class="fa-solid fa-shield-alt"></i>
                    </div>
                    <h3>Terpercaya</h3>
                    <p>Informasi akurat dan update</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section with Enhanced Design -->
    <section class="faq-main-section">
        <div class="container">
            <!-- Filter Header -->
            <div class="faq-filter-header">
                <h2 class="faq-filter-title">Pilih Kategori</h2>
                <p class="faq-filter-subtitle">Temukan jawaban berdasarkan topik yang Anda butuhkan</p>
            </div>

            <!-- Category Filter Tabs -->
            <div class="faq-filter-container">
                <div class="faq-filter-tabs" id="faqFilterTabs">
                    <?php 
                    $isFirst = true;
                    $categoryIcons = [
                        'Pemesanan' => 'icon-plane',
                        'Pembayaran' => 'fa-solid fa-credit-card',
                        'Kebijakan' => 'fa-solid fa-file-alt',
                        'Layanan' => 'fa-solid fa-concierge-bell'
                    ];
                    
                    foreach ($faqData as $category): 
                        $catKey = strtolower(str_replace(' ', '-', $category['category']));
                        $iconClass = $categoryIcons[$category['category']] ?? 'icon-question-circle';
                        $itemCount = count($category['items']);
                    ?>
                        <button class="faq-filter-tab <?php echo $isFirst ? 'active' : ''; ?>" 
                                data-category="<?php echo $catKey; ?>" 
                                onclick="faqApp.switchCategory('<?php echo $catKey; ?>')">
                            <div class="faq-filter-tab-icon">
                                <i class="<?php echo $iconClass; ?>"></i>
                            </div>
                            <div class="faq-filter-tab-content">
                                <span class="faq-filter-tab-name"><?php echo htmlspecialchars($category['category']); ?></span>
                                <span class="faq-filter-tab-desc"><?php echo $itemCount; ?> pertanyaan</span>
                            </div>
                            <div class="faq-filter-tab-badge"><?php echo $itemCount; ?></div>
                        </button>
                    <?php 
                        $isFirst = false;
                    endforeach; 
                    ?>
                </div>
            </div>

            <!-- FAQ Content Area -->
            <div class="faq-content-section">
                <!-- Section Header for Current Category -->
                <div class="faq-section-header" id="faqSectionHeader">
                    <h2 class="faq-section-title" id="faqSectionTitle">Pertanyaan Seputar Pemesanan</h2>
                    <p class="faq-section-subtitle" id="faqSectionSubtitle">Semua yang perlu Anda ketahui tentang cara memesan tiket</p>
                </div>

                <!-- FAQ Accordion Items -->
                <div class="faq-accordion-container" id="faqAccordion">
                    <?php foreach ($faqData as $categoryIndex => $category): 
                        $catKey = strtolower(str_replace(' ', '-', $category['category']));
                    ?>
                        <div class="faq-category-group <?php echo $categoryIndex === 0 ? 'active' : ''; ?>" 
                             data-category="<?php echo $catKey; ?>"
                             style="<?php echo $categoryIndex === 0 ? 'display: block;' : 'display: none;'; ?>">
                            <?php foreach ($category['items'] as $itemIndex => $item): 
                                $uniqueId = $catKey . '-' . $itemIndex;
                            ?>
                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-question" onclick="faqApp.toggleItem('<?php echo $uniqueId; ?>')">
                                        <span class="faq-question-number"><?php echo ($itemIndex + 1); ?></span>
                                        <span class="faq-question-text">
                                            <?php echo htmlspecialchars($item['question']); ?>
                                        </span>
                                        <i class="icon icon-chevron-down faq-chevron" id="icon-<?php echo $uniqueId; ?>"></i>
                                    </button>
                                    <div class="faq-accordion-answer" id="answer-<?php echo $uniqueId; ?>">
                                        <div class="faq-answer-content">
                                            <?php echo $item['answer']; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Enhanced Contact CTA -->
            <div class="faq-help-cta">
                <div class="faq-help-content">
                    <div class="faq-help-icon">
                        <i class="icon icon-whatsapp"></i>
                    </div>
                    <h3>Tidak Menemukan Jawaban?</h3>
                    <p>Tim customer service kami siap membantu Anda kapan saja melalui WhatsApp</p>
                </div>
                <div class="faq-help-actions">
                    <a href="https://wa.me/<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>" 
                       class="btn-faq-primary" target="_blank">
                        <i class="icon icon-whatsapp"></i>
                        <span>Hubungi via WhatsApp</span>
                    </a>
                    <a href="kontak.php" class="btn-faq-secondary">
                        <i class="icon icon-phone"></i>
                        <span>Lihat Info Kontak</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

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
                    <p><i class="icon icon-map-marker-alt"></i> <?php echo $companyInfoData['address']; ?></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 <?php echo htmlspecialchars($companyInfoData['name']); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <div class="wa-float">
        <a href="https://wa.me/<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>" target="_blank">
            <i class="icon icon-whatsapp"></i>
        </a>
    </div>

    <script src="config.js"></script>
    <script src="script.js"></script>
    
    <!-- FAQ Enhanced Script -->
    <script>
        const faqApp = {
            currentCategory: null,
            
            init() {
                console.log('🚀 FAQ App Initializing...');
                
                // Get the active tab (first tab should already have 'active' class from PHP)
                const activeTab = document.querySelector('.faq-filter-tab.active');
                if (activeTab) {
                    this.currentCategory = activeTab.dataset.category;
                    console.log('✅ FAQ App Ready - Active category:', this.currentCategory);
                } else {
                    // Fallback: if no active tab, set first one
                    const firstTab = document.querySelector('.faq-filter-tab');
                    if (firstTab) {
                        const defaultCategory = firstTab.dataset.category;
                        this.currentCategory = defaultCategory;
                        firstTab.classList.add('active');
                        
                        // Show first category group
                        const firstGroup = document.querySelector(`.faq-category-group[data-category="${defaultCategory}"]`);
                        if (firstGroup) {
                            firstGroup.style.display = 'block';
                            firstGroup.classList.add('active');
                        }
                        
                        console.log('✅ FAQ App Ready (Fallback) - Default category:', this.currentCategory);
                    }
                }
            },
            
            switchCategory(category) {
                console.log(`🔄 Switching to category: ${category}`);
                this.currentCategory = category;
                
                // Update active tab
                document.querySelectorAll('.faq-filter-tab').forEach(tab => {
                    tab.classList.remove('active');
                    if (tab.dataset.category === category) {
                        tab.classList.add('active');
                    }
                });
                
                // Show/hide category groups without animation
                document.querySelectorAll('.faq-category-group').forEach(group => {
                    if (group.dataset.category === category) {
                        group.style.display = 'block';
                    } else {
                        group.style.display = 'none';
                    }
                });
                
                // Close all open items when switching categories
                document.querySelectorAll('.faq-accordion-item').forEach(item => {
                    item.classList.remove('active');
                });
                
                // Update section header
                this.updateSectionHeader(category);
            },
            
            updateSectionHeader(category) {
                const titles = {
                    'pemesanan': {
                        title: 'Pertanyaan Seputar Pemesanan',
                        subtitle: 'Semua yang perlu Anda ketahui tentang cara memesan tiket'
                    },
                    'pembayaran': {
                        title: 'Pertanyaan Seputar Pembayaran',
                        subtitle: 'Informasi lengkap mengenai metode dan proses pembayaran'
                    },
                    'kebijakan': {
                        title: 'Kebijakan & Ketentuan',
                        subtitle: 'Pelajari kebijakan pembatalan, perubahan, dan ketentuan lainnya'
                    },
                    'layanan': {
                        title: 'Layanan & Fasilitas',
                        subtitle: 'Informasi tentang layanan dan fasilitas yang kami sediakan'
                    }
                };
                
                const headerData = titles[category] || {
                    title: 'Frequently Asked Questions',
                    subtitle: 'Temukan jawaban yang Anda butuhkan'
                };
                
                const titleEl = document.getElementById('faqSectionTitle');
                const subtitleEl = document.getElementById('faqSectionSubtitle');
                
                if (titleEl) titleEl.textContent = headerData.title;
                if (subtitleEl) subtitleEl.textContent = headerData.subtitle;
            },
            
            toggleItem(id) {
                const answer = document.getElementById(`answer-${id}`);
                if (!answer) {
                    console.error('Answer element not found:', id);
                    return;
                }
                
                const item = answer.parentElement;
                const currentCategory = document.querySelector('.faq-category-group[style*="display: block"], .faq-category-group:not([style*="display: none"])');
                const allItems = currentCategory ? currentCategory.querySelectorAll('.faq-accordion-item') : [];
                
                // Check if item is currently active
                const isActive = item.classList.contains('active');
                
                // Close all other items in the same category
                allItems.forEach(otherItem => {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                        const otherAnswer = otherItem.querySelector('.faq-accordion-answer');
                        if (otherAnswer) {
                            otherAnswer.style.maxHeight = null;
                        }
                    }
                });
                
                // Toggle current item
                if (!isActive) {
                    item.classList.add('active');
                    answer.style.maxHeight = null;
                    setTimeout(() => {
                        answer.style.maxHeight = answer.scrollHeight + 'px';
                    }, 10);
                } else {
                    item.classList.remove('active');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    setTimeout(() => {
                        answer.style.maxHeight = null;
                    }, 10);
                }
            }
        };
        
        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            console.log('🌟 DOM Content Loaded - Starting FAQ App');
            faqApp.init();
        });
        
        // Export for global access
        window.faqApp = faqApp;
    </script>
</body>
</html>

