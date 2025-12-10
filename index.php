<?php
// Load data dari database
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/home_content_functions.php';

// Get homepage settings and contact info from database
$homepageSettings = getHomepageSettings();
$contactInfo = getContactInfo();

// Get dynamic home content
$serviceCards = getAllServiceCards();
$whyChooseUs = getAllWhyChooseUs();
$paymentSteps = getAllPaymentSteps();
$orderSteps = getAllOrderSteps();
$galleryHomeSelection = getAllGalleryHomeSelection();

// Set variabel global untuk digunakan di footer
$companyName = $homepageSettings['company_name'] ?? 'CV. Cendana Travel';
$companyAddress = $homepageSettings['company_address'] ?? 'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur 75127';
$companyHours = $homepageSettings['company_hours'] ?? 'Senin - Minggu: 08.00 - 22.00 WIB';
$companyEmail = $homepageSettings['company_email'] ?? 'info@cendanatravel.com';
$companyWhatsapp = $homepageSettings['company_whatsapp'] ?? '6285821841529';
$companyInstagram = $homepageSettings['company_instagram'] ?? '@cendanatravel_official';
$companyTiktok = $homepageSettings['company_tiktok'] ?? '';
$footerDescription = $homepageSettings['footer_description'] ?? 'Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda.';

// Data untuk company info - semua dari homepage_settings
$companyInfoData = [
    'name' => $companyName,
    'whatsapp' => $companyWhatsapp,
    'instagram' => $companyInstagram,
    'tiktok' => $companyTiktok,
    'email' => $companyEmail,
    'address' => $companyAddress,
    'hours' => $companyHours,
    'description' => $footerDescription,
    'phone' => $contactInfo['phone'] ?? '(0541) 123456',
    'facebook' => $contactInfo['facebook'] ?? '',
    'twitter' => $contactInfo['twitter'] ?? '',
    'maps_embed' => $contactInfo['maps_embed'] ?? ''
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($companyInfoData['name']); ?> - Layanan Travel Terpercaya</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="icons.css">
    <link rel="stylesheet" href="beranda-dynamic.css?v=<?= time() + 1 ?>">
</head>
<body>
    <!-- Header Navigation -->
    <header>
        <div class="container header-container">
            <a href="#" class="logo"><?php echo htmlspecialchars($companyInfoData['name']); ?></a>
            
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php" class="active">Beranda</a></li>
                    <li><a href="pemesanan.php">Pemesanan</a></li>
                    <li><a href="galeri.php">Galeri</a></li>
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

    <!-- Hero Section Dynamic -->
    <section class="hero hero-dynamic" id="home" <?php if (!empty($homepageSettings['hero_background'])): ?>style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('uploads/<?php echo htmlspecialchars($homepageSettings['hero_background']); ?>'); background-size: cover; background-position: center; background-attachment: fixed;"<?php endif; ?>>
        <!-- Background Layers -->
        <div class="hero-background-layer" <?php if (!empty($homepageSettings['hero_background'])): ?>style="opacity: 0.3;"<?php endif; ?>></div>
        <div class="hero-pattern-overlay"></div>
        
        <!-- Floating Elements -->
        <div class="hero-floating-elements">
            <div class="float-circle"></div>
            <div class="float-square"></div>
        </div>
        
        <!-- Content Layer -->
        <div class="hero-content-layer">
            <div class="container">
                <div class="hero-content fade-in-up">
                    <h1 class="hero-title">
                        <?php echo htmlspecialchars($homepageSettings['hero_title'] ?? 'Perjalanan Impian'); ?><br>
                        <span class="hero-company"><?php echo htmlspecialchars($homepageSettings['hero_subtitle'] ?? 'Dimulai dari Sini'); ?></span>
                    </h1>
                    
                    <p class="hero-description">
                        <?php echo htmlspecialchars($homepageSettings['hero_description'] ?? 'Layanan travel profesional dengan pengalaman lebih dari 10 tahun. Kami mengutamakan kenyamanan dan keamanan perjalanan Anda ke seluruh penjuru nusantara.'); ?>
                    </p>
                    
                    <div class="hero-cta">
                        <a href="pemesanan.php" class="btn-hero btn-hero-primary">
                            <i class="icon icon-plane"></i>
                            <span>Jelajahi Layanan</span>
                        </a>
                        <a href="https://wa.me/<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>" class="btn-hero btn-hero-secondary" target="_blank">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>
                            </svg>
                            <span>Hubungi Kami</span>
                        </a>
                    </div>
                    
                    <div class="hero-stats">
                        <div class="stat-card fade-in" style="animation-delay: 0.2s;">
                            <div class="stat-number"><?php echo htmlspecialchars($homepageSettings['stats_years'] ?? '10+'); ?></div>
                            <div class="stat-label"><?php echo htmlspecialchars($homepageSettings['stats_years_label'] ?? 'Tahun Pengalaman'); ?></div>
                        </div>
                        <div class="stat-card fade-in" style="animation-delay: 0.4s;">
                            <div class="stat-number"><?php echo htmlspecialchars($homepageSettings['stats_customers'] ?? '5000+'); ?></div>
                            <div class="stat-label"><?php echo htmlspecialchars($homepageSettings['stats_customers_label'] ?? 'Pelanggan Puas'); ?></div>
                        </div>
                        <div class="stat-card fade-in" style="animation-delay: 0.6s;">
                            <div class="stat-number"><?php echo htmlspecialchars($homepageSettings['stats_rating'] ?? '4.9'); ?></div>
                            <div class="stat-label"><?php echo htmlspecialchars($homepageSettings['stats_rating_label'] ?? 'Rating'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section Dynamic -->
    <section class="services-section services-dynamic">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2>Jelajahi Dunia,<br><span style="color: #D4956E;">Kapan Saja & Dimana Saja</span></h2>
                <p>Pilih moda transportasi favorit Anda dengan pelayanan premium.</p>
            </div>

            <?php 
            // Filter active cards
            $activeCards = array_filter($serviceCards, function($card) {
                return $card['is_active'];
            });
            $activeCards = array_values($activeCards); // Reindex array
            $totalCards = count($activeCards);
            
            // Process cards in groups of 3
            $cardIndex = 0;
            $delay = 0.1;
            
            while ($cardIndex < $totalCards):
                $remainingCards = $totalCards - $cardIndex;
                
                // Determine grid type based on remaining cards
                if ($remainingCards >= 3) {
                    // Group of 3: Asymmetric grid (1 featured + 2 regular)
                    $gridClass = 'services-asymmetric-grid';
                    $cardsToRender = 3;
                } else {
                    // Less than 3: Uniform grid (all regular)
                    $gridClass = 'services-uniform-grid';
                    $cardsToRender = $remainingCards;
                }
            ?>
                <div class="<?= $gridClass ?>" style="margin-top: <?= ($cardIndex > 0) ? '3rem' : '4rem' ?>;">
                    <?php 
                    for ($i = 0; $i < $cardsToRender; $i++):
                        $card = $activeCards[$cardIndex];
                        $isFirstInGroup = ($i === 0);
                        $shouldBeFeatured = ($remainingCards >= 3 && $isFirstInGroup);
                    ?>
                        <?php if ($shouldBeFeatured): ?>
                            <!-- Featured Service Card (Large) -->
                            <article class="service-card-featured fade-in-up" style="animation-delay: <?= $delay ?>s;">
                                <?php if ($card['badge_text']): ?>
                                <span class="popular-badge"><?= htmlspecialchars($card['badge_text']) ?></span>
                                <?php endif; ?>
                                <div class="service-image">
                                    <img src="<?= htmlspecialchars($card['image']) ?>" alt="<?= htmlspecialchars($card['title']) ?>">
                                </div>
                                <div class="service-content">
                                    <div class="service-icon-inline">
                                        <h3><?= htmlspecialchars($card['title']) ?></h3>
                                    </div>
                                    <p><?= htmlspecialchars($card['description']) ?></p>
                                    <?php 
                                    $features = json_decode($card['features'], true);
                                    if (!empty($features) && is_array($features)): 
                                    ?>
                                    <ul class="service-features">
                                        <?php foreach ($features as $feature): ?>
                                        <li>✓ <?= htmlspecialchars($feature) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php endif; ?>
                                    <a href="<?= htmlspecialchars($card['button_link']) ?>" class="service-btn"><?= htmlspecialchars($card['button_text']) ?></a>
                                </div>
                            </article>
                        <?php else: ?>
                            <!-- Regular Service Card (Small) -->
                            <article class="service-card-small fade-in-up" style="animation-delay: <?= $delay ?>s;">
                                <div class="service-image-small">
                                    <img src="<?= htmlspecialchars($card['image']) ?>" alt="<?= htmlspecialchars($card['title']) ?>">
                                </div>
                                <div class="service-content-small">
                                    <div class="service-icon-inline">
                                        <h3><?= htmlspecialchars($card['title']) ?></h3>
                                    </div>
                                    <p><?= htmlspecialchars($card['description']) ?></p>
                                    <a href="<?= htmlspecialchars($card['button_link']) ?>" class="service-btn-small"><?= htmlspecialchars($card['button_text']) ?></a>
                                </div>
                            </article>
                        <?php endif; ?>
                    <?php 
                        $delay += 0.1;
                        $cardIndex++;
                    endfor; 
                    ?>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Why Us Section Redesign - Split Layout -->
    <section class="why-us-split-section">
        <div class="container">
            <div class="why-us-split-container">
                <!-- Left Side: Sticky Content -->
                <div class="why-us-content-side">
                    <div class="why-us-sticky-wrapper fade-in-up">
                        <span class="section-badge">Keunggulan Kami</span>
                        <h2>Mengapa Memilih <br><span class="highlight-text">Cendana Travel?</span></h2>
                        <p>Kami berkomitmen memberikan pengalaman perjalanan terbaik dengan standar keamanan dan kenyamanan tinggi untuk setiap penumpang.</p>
                        
                        <div class="why-us-image-decor">
                            <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80" alt="Travel Experience">
                            <div class="decor-badge">
                                <span class="badge-number">10+</span>
                                <span class="badge-text">Tahun<br>Pengalaman</span>
                            </div>
                        </div>

                        <a href="tentang.php" class="btn-why-us">
                            <span>Tentang Kami</span>
                            <i class="icon icon-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Side: Grid Cards -->
                <div class="why-us-grid-side">
                    <div class="why-us-grid-compact three-columns">
                        <?php 
                        $delay = 0.1;
                        foreach ($whyChooseUs as $item): 
                        ?>
                        <?php if ($item['is_active']): ?>
                        <div class="feature-card-compact fade-in-up" style="animation-delay: <?= $delay ?>s;">
                            <div class="feature-icon-compact">
                                <?php 
                                $icon = $item['icon'];
                                if ($icon && substr($icon, 0, 6) === 'class:'): 
                                    $iconClass = substr($icon, 6);
                                ?>
                                    <i class="icon <?= htmlspecialchars($iconClass) ?>"></i>
                                <?php elseif ($icon && file_exists($icon)): ?>
                                    <img src="<?= htmlspecialchars($icon) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                                <?php else: ?>
                                    <i class="icon icon-check"></i>
                                <?php endif; ?>
                            </div>
                            <div class="feature-content-compact">
                                <h3><?= htmlspecialchars($item['title']) ?></h3>
                                <p><?= htmlspecialchars($item['description']) ?></p>
                            </div>
                        </div>
                        <?php 
                            $delay += 0.1;
                            endif; 
                        ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Methods Section - Horizontal Scroll -->
    <section class="payment-methods-section payment-carousel">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2>Cara Pembayaran</h2>
                <p>Ikuti langkah berikut untuk menyelesaikan pembayaran dengan mudah dan aman.</p>
            </div>

            <div class="horizontal-scroll-wrapper">
                <div class="horizontal-scroll-container">
                    <?php foreach ($paymentSteps as $step): ?>
                    <?php if ($step['is_active']): ?>
                    <article class="payment-card-scroll">
                        <div class="payment-step-icon-wrapper">
                            <div class="payment-step-icon-background">
                                <?php if ($step['icon'] && (strpos($step['icon'], 'class:') === 0 || strpos($step['icon'], 'fa-') !== false || strpos($step['icon'], 'icon-') !== false)): ?>
                                    <?php $iconClass = strpos($step['icon'], 'class:') === 0 ? substr($step['icon'], 6) : $step['icon']; ?>
                                    <i class="<?= htmlspecialchars($iconClass) ?>" style="font-size: 24px; color: #D4956E;"></i>
                                <?php elseif ($step['icon'] && file_exists($step['icon'])): ?>
                                    <img src="<?= htmlspecialchars($step['icon']) ?>" alt="<?= htmlspecialchars($step['title']) ?>" style="width: 40px; height: 40px; object-fit: contain;">
                                <?php else: ?>
                                    <i class="icon icon-check-circle"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                        <h3><?= htmlspecialchars($step['title']) ?></h3>
                        <p><?= htmlspecialchars($step['description']) ?></p>
                    </article>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: TESTIMONI PELANGGAN - SLIDER -->
    <section class="testimonials-new-section testimonials-slider">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2>Apa Kata Pelanggan Kami?</h2>
                <p>Ribuan pelanggan puas telah mempercayai layanan kami untuk perjalanan mereka</p>
            </div>

            <div class="testimonial-carousel">
                <div class="testimonial-track" id="testimonialTrack">
                    <!-- Page 1 -->
                    <div class="testimonial-page">
                        <!-- Testimonial Slide 1 -->
                        <div class="testimonial-slide">
                            <div class="testimonial-header">
                                <div class="testimonial-avatar" style="background: linear-gradient(135deg, #D4956E 0%, #B8704D 100%);">
                                    <span>EB</span>
                                </div>
                                <div class="testimonial-info">
                                    <h4>Eddy Batuna</h4>
                                    <div class="testimonial-rating">
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="testimonial-text">"Pelayanan luar biasa! Proses pemesanan mudah dan respon admin sangat cepat. Rekomendasi terbaik untuk travel ke Indonesia. Sudah beberapa kali menggunakan jasa mereka dan tidak pernah mengecewakan."</p>
                        </div>

                        <!-- Testimonial Slide 2 -->
                        <div class="testimonial-slide">
                            <div class="testimonial-header">
                                <div class="testimonial-avatar" style="background: linear-gradient(135deg, #F4A460 0%, #D4956E 100%);">
                                    <span>AH</span>
                                </div>
                                <div class="testimonial-info">
                                    <h4>Ali Harsyah</h4>
                                    <div class="testimonial-rating">
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="testimonial-text">"Harga kompetitif dengan pelayanan terbaik. Tim sangat membantu dan responsif. Saya puas dengan layanan mereka! Proses booking cepat dan mudah, highly recommended untuk yang butuh tiket pesawat, kapal, atau bus."</p>
                        </div>
                    </div>

                    <!-- Page 2 -->
                    <div class="testimonial-page">
                        <!-- Testimonial Slide 3 -->
                        <div class="testimonial-slide">
                            <div class="testimonial-header">
                                <div class="testimonial-avatar" style="background: linear-gradient(135deg, #8B7355 0%, #6B5344 100%);">
                                    <span>SA</span>
                                </div>
                                <div class="testimonial-info">
                                    <h4>Siti Aminah</h4>
                                    <div class="testimonial-rating">
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="testimonial-text">"Perjalanan pertama saya sangat memuaskan. Dari booking hingga sampai tujuan semuanya lancar. Terima kasih Cendana Travel!"</p>
                        </div>

                        <!-- Testimonial Slide 4 -->
                        <div class="testimonial-slide">
                            <div class="testimonial-header">
                                <div class="testimonial-avatar" style="background: linear-gradient(135deg, #2D3748 0%, #1A202C 100%);">
                                    <span>BS</span>
                                </div>
                                <div class="testimonial-info">
                                    <h4>Budi Santoso</h4>
                                    <div class="testimonial-rating">
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                        <i class="icon icon-star-fill"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="testimonial-text">"Sangat profesional dan terpercaya. Armada yang digunakan sangat nyaman dan bersih. Driver ramah dan tepat waktu. Pasti akan langganan terus."</p>
                        </div>
                    </div>
                </div>

                <!-- Carousel Dots -->
                <div class="carousel-dots" id="carouselDots">
                    <span class="carousel-dot active" data-slide="0"></span>
                    <span class="carousel-dot" data-slide="1"></span>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: CARA PEMESANAN - ALTERNATING LAYOUT -->
    <section class="booking-steps-alternating">
        <div class="container">
            <div class="section-header-booking fade-in-up">
                <h2>Bagaimana Cara Memesan?</h2>
                <p>Proses pemesanan tiket yang mudah dan cepat dalam 3 langkah sederhana.</p>
            </div>

            <?php 
            $stepIndex = 0;
            foreach ($orderSteps as $step): 
                if (!$step['is_active']) continue;
                $stepIndex++;
                $isLeft = ($stepIndex % 2) != 0; // Odd = left, Even = right
                $delay = $stepIndex * 0.1;
            ?>
            <!-- Step <?= $stepIndex ?>: <?= $isLeft ? 'Image Left, Content Right' : 'Content Left, Image Right' ?> -->
            <div class="booking-step-row booking-step-<?= $isLeft ? 'left' : 'right' ?> fade-in-up" style="animation-delay: <?= $delay ?>s;">
                <?php if ($isLeft): ?>
                <div class="booking-step-image">
                    <?php if ($step['image'] && file_exists($step['image'])): ?>
                        <img src="<?= htmlspecialchars($step['image']) ?>" alt="<?= htmlspecialchars($step['title']) ?>">
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80" alt="<?= htmlspecialchars($step['title']) ?>">
                    <?php endif; ?>
                </div>
                <div class="booking-step-content">
                    <h3><?= htmlspecialchars($step['title']) ?></h3>
                    <p><?= htmlspecialchars($step['description']) ?></p>
                </div>
                <?php else: ?>
                <div class="booking-step-content">
                    <h3><?= htmlspecialchars($step['title']) ?></h3>
                    <p><?= htmlspecialchars($step['description']) ?></p>
                </div>
                <div class="booking-step-image">
                    <?php if ($step['image'] && file_exists($step['image'])): ?>
                        <img src="<?= htmlspecialchars($step['image']) ?>" alt="<?= htmlspecialchars($step['title']) ?>">
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=800&q=80" alt="<?= htmlspecialchars($step['title']) ?>">
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- SECTION 4: GALERI FOTO - POLAROID CARDS -->
    <section class="gallery-polaroid-section">
        <div class="container">
            <div class="gallery-polaroid-wrapper">
                
                <!-- Polaroid Cards Stack -->
                <div class="polaroid-cards-stack">
                    <?php 
                    $cardPositions = ['far-left', 'left', 'center', 'right', 'far-right'];
                    $cardIndex = 0;
                    foreach ($galleryHomeSelection as $galItem): 
                        $position = $cardPositions[$cardIndex % 5];
                        $cardIndex++;
                    ?>
                    <!-- Card <?= ucfirst($position) ?> -->
                    <div class="polaroid-card-home card-<?= $position ?>-home">
                        <?php if ($galItem['image_path'] && file_exists($galItem['image_path'])): ?>
                            <img src="<?= htmlspecialchars($galItem['image_path']) ?>" alt="<?= htmlspecialchars($galItem['title'] ?? $galItem['description']) ?>">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?auto=format&fit=crop&w=600&q=80" alt="<?= htmlspecialchars($galItem['description']) ?>">
                        <?php endif; ?>
                    </div>
                    <?php 
                    if ($cardIndex >= 5) break; // Max 5 photos
                    endforeach; 
                    
                    // Fill remaining slots if less than 5
                    $defaultImages = [
                        'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?auto=format&fit=crop&w=600&q=80',
                        'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=600&q=80',
                        'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=600&q=80',
                        'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=600&q=80',
                        'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?auto=format&fit=crop&w=600&q=80'
                    ];
                    
                    while ($cardIndex < 5):
                        $position = $cardPositions[$cardIndex % 5];
                    ?>
                    <div class="polaroid-card-home card-<?= $position ?>-home">
                        <img src="<?= $defaultImages[$cardIndex] ?>" alt="Galeri Perjalanan">
                    </div>
                    <?php 
                    $cardIndex++;
                    endwhile;
                    ?>
                </div>
                
                <!-- Text Content -->
                <div class="gallery-polaroid-content">
                    <h2 class="gallery-polaroid-title">Galeri Perjalanan</h2>
                    <p class="gallery-polaroid-subtitle">
                        Temukan inspirasi destinasi wisata terbaik dari koleksi perjalanan kami yang tak terlupakan.
                    </p>
                    <a href="galeri.php" class="btn-gallery-polaroid">Lihat Selengkapnya</a>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Footer Premium -->
    <footer class="footer-premium">
        <div class="footer-container-custom">
            <!-- Divider Line Top -->
            <div class="footer-divider-top"></div>
            
            <!-- Main Grid: 3 Kolom -->
            <div class="footer-grid-premium">
                
                <!-- KOLOM 1: Tentang Kami -->
                <section class="footer-section-premium">
                    <h3 class="footer-heading-premium"><?php echo htmlspecialchars($companyInfoData['name']); ?></h3>
                    <p class="footer-text-premium">
                        <?php echo htmlspecialchars($companyInfoData['description']); ?>
                    </p>
                    <div class="footer-hours-box">
                        <p class="footer-hours-label">Jam Operasional:</p>
                        <p class="footer-hours-text">
                            <?php echo htmlspecialchars($companyInfoData['hours']); ?>
                        </p>
                    </div>
                </section>

                <!-- KOLOM 2: Navigasi -->
                <section class="footer-section-premium">
                    <h3 class="footer-heading-premium">Navigasi</h3>
                    <ul class="footer-links-premium">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="pemesanan.php">Pemesanan</a></li>
                        <li><a href="galeri.php">Galeri</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                        <li><a href="kontak.php">Kontak</a></li>
                    </ul>
                </section>

                <!-- KOLOM 3: Hubungi Kami -->
                <section class="footer-section-premium">
                    <h3 class="footer-heading-premium">Hubungi Kami</h3>
                    
                    <div class="footer-contact-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="footer-contact-icon" style="color: #25D366;">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>
                        </svg>
                        <div class="footer-contact-content">
                            <p class="footer-contact-label">WhatsApp</p>
                            <a href="https://wa.me/6285821841529" class="footer-link-contact">
                                0858-2184-1529
                            </a>
                        </div>
                    </div>
                    
                    <div class="footer-contact-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="footer-contact-icon" style="color: #D4956E;">
                            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                        <div class="footer-contact-content">
                            <p class="footer-contact-label">Email</p>
                            <a href="mailto:admin@cendanatravel.com" class="footer-link-contact">
                                admin@cendanatravel.com
                            </a>
                        </div>
                    </div>
                    
                    <div class="footer-contact-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="footer-contact-icon" style="color: #D4956E;">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        <div class="footer-contact-content">
                            <p class="footer-contact-label">Alamat</p>
                            <p class="footer-address-text">
                                <?php echo nl2br(htmlspecialchars($companyAddress)); ?>
                            </p>
                        </div>
                    </div>
                </section>

            </div>

            <!-- Divider Line Middle -->
            <div class="footer-divider-middle"></div>

            <!-- Footer Bottom: Copyright & Admin Login -->
            <div class="footer-bottom-premium">
                <p class="footer-copyright-premium">
                    <?php echo htmlspecialchars($homepageSettings['footer_copyright'] ?? '© 2024 CV. Cendana Travel. All rights reserved.'); ?>
                </p>
                <a href="auth.php" class="footer-admin-login" title="Login Admin">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/>
                    </svg>
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

    <script src="config.js"></script>
    <script src="script.js"></script>
    <script src="beranda-animations.js"></script>
</body>
</html>
