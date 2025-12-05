<?php
// Data default untuk menghindari error database
$companyInfoData = [
    'name' => 'CV. Cendana Travel',
    'whatsapp' => '6285821841529',
    'instagram' => '@cendanatravel_official',
    'email' => 'info@cendanatravel.com',
    'address' => 'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang<br>Kota Samarinda, Kalimantan Timur 75127',
    'hours' => 'Senin - Minggu: 08.00 - 22.00 WIB',
    'description' => 'Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda.'
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
    <link rel="stylesheet" href="beranda-dynamic.css">
    <link rel="stylesheet" href="section-dividers-optimized.css">
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
    <section class="hero hero-dynamic" id="home">
        <!-- Background Layers -->
        <div class="hero-background-layer"></div>
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
                        Perjalanan Impian<br>
                        <span class="hero-company">Dimulai dari Sini</span>
                    </h1>
                    
                    <p class="hero-description">
                        Layanan travel profesional dengan pengalaman lebih dari 10 tahun. Kami mengutamakan kenyamanan dan keamanan perjalanan Anda ke seluruh penjuru nusantara.
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
                            <div class="stat-number" data-target="10">0</div>
                            <div class="stat-label">Tahun Pengalaman</div>
                        </div>
                        <div class="stat-card fade-in" style="animation-delay: 0.4s;">
                            <div class="stat-number" data-target="5000">0</div>
                            <div class="stat-label">Pelanggan Puas</div>
                        </div>
                        <div class="stat-card fade-in" style="animation-delay: 0.6s;">
                            <div class="stat-number" data-target="4.9">0</div>
                            <div class="stat-label">Rating</div>
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

            <div class="services-asymmetric-grid">
                <!-- Featured Service Card (Large) - Pesawat -->
                <article class="service-card-featured fade-in-up" style="animation-delay: 0.1s;">
                    <span class="popular-badge">Terpopuler</span>
                    <div class="service-image">
                        <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1200&h=600&fit=crop&q=80" alt="Tiket Pesawat">
                    </div>
                    <div class="service-content">
                        <div class="service-icon-inline">
                            <h3>✈️ Tiket Pesawat</h3>
                        </div>
                        <p>Terbang ke seluruh destinasi domestik dan internasional dengan harga kompetitif. Proses booking instan dan terpercaya dengan sistem pembayaran yang aman.</p>
                        <ul class="service-features">
                            <li>✓ Penerbangan Internasional & Domestik</li>
                            <li>✓ Proses Check-in Mudah</li>
                            <li>✓ Garansi Harga Terbaik</li>
                        </ul>
                        <a href="pemesanan.php?type=pesawat" class="service-btn">Cari Penerbangan →</a>
                    </div>
                </article>
                
                <!-- Regular Service Cards (Small) -->
                <article class="service-card-small fade-in-up" style="animation-delay: 0.2s;">
                    <div class="service-image-small">
                        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=800&h=500&fit=crop&q=80" alt="Tiket Bus Premium">
                    </div>
                    <div class="service-content-small">
                        <div class="service-icon-inline">
                            <h3>🚌 Tiket Bus Premium</h3>
                        </div>
                        <p>Perjalanan darat yang nyaman dengan armada terbaru dan fasilitas lengkap untuk perjalanan antar kota yang nyaman dan terjangkau.</p>
                        <a href="pemesanan.php?type=bus" class="service-btn-small">Pesan Tiket Bus</a>
                    </div>
                </article>
                
                <article class="service-card-small fade-in-up" style="animation-delay: 0.3s;">
                    <div class="service-image-small">
                        <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&h=500&fit=crop&q=80" alt="Tiket Kapal Laut">
                    </div>
                    <div class="service-content-small">
                        <div class="service-icon-inline">
                            <h3>🚢 Tiket Kapal Laut</h3>
                        </div>
                        <p>Nikmati perjalanan laut antar pulau dengan aman dan pemandangan indah. Booking kapal penumpang yang nyaman dan aman ke berbagai pelabuhan.</p>
                        <a href="pemesanan.php?type=kapal" class="service-btn-small">Pesan Tiket Kapal</a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Why Us Section Split Screen -->
    <section class="why-us-section why-us-split">
        <div class="split-layout">
            <!-- Left Side - Image/Color Block -->
            <div class="split-image slide-in-left">
                <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=800" alt="Travel Experience">
            </div>
            
            <!-- Right Side - Content -->
            <div class="split-content slide-in-right">
                <h2>Mengapa Memilih Kami?</h2>
                <p style="font-size: 1.1rem; color: #6B7280; margin-bottom: 2rem;">Kepercayaan pelanggan adalah prioritas utama kami dalam memberikan layanan travel terbaik</p>
                
                <ul class="benefit-list">
                    <li class="benefit-item">
                        <div class="benefit-icon">
                            <i class="icon icon-check"></i>
                        </div>
                        <div class="benefit-text">
                            <h3>Legal & Terpercaya</h3>
                            <p>Perusahaan travel resmi dengan izin operasional lengkap dari badan pemerintah yang kompeten.</p>
                        </div>
                    </li>
                    
                    <li class="benefit-item">
                        <div class="benefit-icon">
                            <i class="icon icon-phone"></i>
                        </div>
                        <div class="benefit-text">
                            <h3>Layanan 24/7</h3>
                            <p>Tim customer service yang responsif siap membantu Anda kapan saja, bahkan di hari libur.</p>
                        </div>
                    </li>
                    
                    <li class="benefit-item">
                        <div class="benefit-icon">
                            <i class="icon icon-shield"></i>
                        </div>
                        <div class="benefit-text">
                            <h3>Aman & Terjamin</h3>
                            <p>Semua transaksi dijamin aman dengan sertifikat keamanan dan perlindungan data pelanggan yang ketat.</p>
                        </div>
                    </li>
                </ul>
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
                    <!-- STEP 1: TRANSFER BANK -->
                    <article class="payment-card-scroll">
                        <div class="payment-step-icon-wrapper">
                            <div class="payment-step-icon-background">
                                <i class="icon icon-bank"></i>
                            </div>
                        </div>
                        <h3>Transfer Bank</h3>
                        <p>Transfer pembayaran ke rekening resmi kami yang tertera. Kami mendukung semua bank besar di Indonesia.</p>
                    </article>

                    <!-- STEP 2: KONFIRMASI PEMBAYARAN -->
                    <article class="payment-card-scroll">
                        <div class="payment-step-icon-wrapper">
                            <div class="payment-step-icon-background">
                                <i class="icon icon-check-circle"></i>
                            </div>
                        </div>
                        <h3>Konfirmasi Pembayaran</h3>
                        <p>Kirim bukti transfer melalui WhatsApp atau form konfirmasi untuk proses verifikasi cepat.</p>
                    </article>

                    <!-- STEP 3: TIKET DIKIRIM -->
                    <article class="payment-card-scroll">
                        <div class="payment-step-icon-wrapper">
                            <div class="payment-step-icon-background">
                                <i class="icon icon-ticket"></i>
                            </div>
                        </div>
                        <h3>Tiket Dikirim</h3>
                        <p>Setelah validasi, e-ticket akan dikirim langsung melalui WhatsApp atau email Anda.</p>
                    </article>
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
                        <p class="testimonial-text">"Perjalanan pertama saya sangat memuaskan. Dari booking hingga sampai tujuan semuanya lancar. Terima kasih Cendana Travel! Customer service yang ramah dan profesional, akan selalu menggunakan layanan ini."</p>
                    </div>
                </div>

                <!-- Carousel Dots -->
                <div class="carousel-dots" id="carouselDots">
                    <span class="carousel-dot active" data-slide="0"></span>
                    <span class="carousel-dot" data-slide="1"></span>
                    <span class="carousel-dot" data-slide="2"></span>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: CARA PEMESANAN - TIMELINE -->
    <section class="booking-steps-section booking-timeline">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2>Bagaimana Cara Memesan?</h2>
                <p>Proses pemesanan yang mudah dan cepat dalam 3 langkah sederhana</p>
            </div>

            <div class="timeline-container">
                <!-- Timeline Line -->
                <div class="timeline-line"></div>

                <!-- Step 1 -->
                <div class="timeline-step fade-in-up" style="animation-delay: 0.1s;">
                    <div class="timeline-marker">1</div>
                    <div class="timeline-content">
                        <h3>Pilih Layanan</h3>
                        <p>Kunjungi halaman Pemesanan dan pilih jenis transportasi yang Anda inginkan (pesawat, kapal, atau bus).</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="timeline-step fade-in-up" style="animation-delay: 0.2s;">
                    <div class="timeline-marker">2</div>
                    <div class="timeline-content">
                        <h3>Hubungi Admin</h3>
                        <p>Klik "Pesan Sekarang" dan isi form. Anda akan diarahkan ke WhatsApp admin untuk konfirmasi.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="timeline-step fade-in-up" style="animation-delay: 0.3s;">
                    <div class="timeline-marker">3</div>
                    <div class="timeline-content">
                        <h3>Lakukan Pembayaran</h3>
                        <p>Transfer pembayaran sesuai instruksi. E-ticket akan dikirimkan setelah konfirmasi pembayaran.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: GALERI FOTO - MASONRY -->
    <section class="gallery-new-section gallery-masonry">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2>Galeri Perjalanan</h2>
                <p>Koleksi momen indah dari perjalanan bersama kami</p>
            </div>

            <div class="masonry-grid">
                <!-- Gallery Item 1 - Tall -->
                <article class="masonry-item tall fade-in" style="animation-delay: 0.1s;">
                    <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Destinasi Pantai">
                    <div class="gallery-new-overlay">
                        <h4>Destinasi Pantai</h4>
                    </div>
                </article>

                <!-- Gallery Item 2 - Regular -->
                <article class="masonry-item fade-in" style="animation-delay: 0.2s;">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Gunung Indah">
                    <div class="gallery-new-overlay">
                        <h4>Gunung Indah</h4>
                    </div>
                </article>

                <!-- Gallery Item 3 - Regular -->
                <article class="masonry-item fade-in" style="animation-delay: 0.3s;">
                    <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Petualangan Laut">
                    <div class="gallery-new-overlay">
                        <h4>Petualangan Laut</h4>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- SECTION 6: LEGALITAS & KEAMANAN - COMPACT 2x2 -->
    <section class="legality-security-section legality-compact">
        <div class="container">
            <div class="section-header fade-in-up">
                <h2>Legalitas & Keamanan</h2>
                <p>Kami menjamin keaslian dan keamanan dalam setiap transaksi</p>
            </div>

            <div class="legality-grid-2x2">
                <!-- Card 1: Terdaftar Resmi -->
                <article class="legality-item fade-in" style="animation-delay: 0.1s;">
                    <div class="legality-icon">
                        <i class="icon icon-certificate"></i>
                    </div>
                    <h3>Terdaftar Resmi</h3>
                    <p>CV. Cendana Travel adalah perusahaan travel yang terdaftar secara resmi di badan pemerintah yang kompeten</p>
                </article>

                <!-- Card 2: Lisensi Operasional -->
                <article class="legality-item fade-in" style="animation-delay: 0.2s;">
                    <div class="legality-icon">
                        <i class="icon icon-license"></i>
                    </div>
                    <h3>Lisensi Operasional</h3>
                    <p>Kami memiliki lisensi operasional lengkap untuk menjalankan bisnis travel dengan izin yang sah</p>
                </article>

                <!-- Card 3: Transaksi Aman -->
                <article class="legality-item fade-in" style="animation-delay: 0.3s;">
                    <div class="legality-icon">
                        <i class="icon icon-lock"></i>
                    </div>
                    <h3>Transaksi Aman</h3>
                    <p>Semua transaksi dilindungi dengan sistem keamanan terkini untuk melindungi data pribadi Anda</p>
                </article>

                <!-- Card 4: Perlindungan Data -->
                <article class="legality-item fade-in" style="animation-delay: 0.4s;">
                    <div class="legality-icon">
                        <i class="icon icon-shield"></i>
                    </div>
                    <h3>Perlindungan Data</h3>
                    <p>Data pribadi pelanggan dijaga ketat sesuai dengan standar perlindungan data internasional</p>
                </article>
            </div>
        </div>
    </section>

    <!-- SECTION 7: CTA PENUTUP - DYNAMIC BANNER -->
    <section class="cta-closing-section cta-dynamic">
        <!-- Gradient Background -->
        <div class="cta-gradient-background"></div>
        
        <div class="container">
            <div class="cta-content-centered fade-in-up">
                <h2>Siap Memulai Perjalanan Anda?</h2>
                <p>Jangan tunda lagi! Hubungi kami sekarang dan dapatkan penawaran terbaik untuk perjalanan impian Anda</p>
                
                <div class="cta-closing-buttons">
                    <a href="https://wa.me/<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>" class="cta-btn cta-btn-primary" target="_blank">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>
                        </svg>
                        <span>Chat WhatsApp Sekarang</span>
                    </a>
                    <a href="pemesanan.php" class="cta-btn cta-btn-secondary">
                        <i class="icon icon-plane"></i>
                        <span>Lihat Paket Perjalanan</span>
                    </a>
                </div>

                <p class="cta-closing-footer">Tersedia 24/7 untuk melayani Anda</p>
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
                    <h3 class="footer-heading-premium">Tentang Kami</h3>
                    <p class="footer-text-premium">
                        Kami adalah penyedia layanan travel terpercaya dengan pengalaman lebih dari 10 tahun dalam melayani perjalanan Anda. Berawal dari lokasi sederhana, kini kami siap melayani kebutuhan liburan Anda.
                    </p>
                    <div class="footer-hours-box">
                        <p class="footer-hours-label">Jam Operasional:</p>
                        <p class="footer-hours-text">
                            Senin - Minggu: 08:00 - 22:00 WIB
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
                                Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunang, Kota Samarinda, Kalimantan Timur 75127
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
                    &copy; 2024 Cv. Cendana Travel. All rights reserved.
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
