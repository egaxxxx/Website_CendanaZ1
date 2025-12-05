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
    <title><?php echo htmlspecialchars($companyInfoData['name']); ?> - Website Travel Terpercaya</title>
    <!-- File CSS kita sendiri -->
    <link rel="stylesheet" href="styles.css">
    <!-- Custom Icons CSS (pengganti FontAwesome) -->
    <link rel="stylesheet" href="icons.css">
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <!-- Logo Perusahaan -->
            <a href="#" class="logo"><?php echo htmlspecialchars($companyInfoData['name']); ?></a>
            
            <!-- Menu Navigasi -->
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php" class="active">Beranda</a></li>
                    <li><a href="pemesanan.php">Pemesanan</a></li>
                    <li><a href="galeri.php">Galeri</a></li>
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

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-overlay">
            <div class="container">
                <div class="hero-content">
                    <!-- Heading Utama -->
                    <h1 class="hero-title">
                        Perjalanan Terpercaya<br>
                        <span class="hero-company">Cendana Travel</span>
                    </h1>
                    
                    <!-- Deskripsi/Tagline -->
                    <p class="hero-description">
                        Layanan travel profesional dengan pengalaman lebih dari 10 tahun. Kami mengutamakan kenyamanan dan keamanan perjalanan Anda.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="hero-cta">
                        <a href="pemesanan.php" class="btn-hero btn-hero-primary">Lihat Layanan</a>
                        <a href="https://wa.me/<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>" class="btn-hero btn-hero-secondary" target="_blank">Hubungi Kami</a>
                    </div>
                    
                    <!-- Statistik/Fitur Highlights -->
                    <div class="hero-stats">
                        <div class="stat-card">
                            <div class="stat-number">10+</div>
                            <div class="stat-label">Tahun Pengalaman</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">150+</div>
                            <div class="stat-label">Pelanggan Puas</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">4.9/5</div>
                            <div class="stat-label">Rating Pelanggan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Profesional -->
    <section class="professional-services" id="professional-services">
        <div class="container">
            <div class="section-header-professional">
                <h2 class="section-title-professional">
                    Layanan Profesional
                </h2>
                <p class="section-description-professional">
                    Kami berkomitmen memberikan layanan travel berkualitas tinggi dengan standar profesional internasional, 
                    memastikan setiap perjalanan Anda menjadi pengalaman yang berkesan dan tak terlupakan.
                </p>
                <div class="section-divider-professional"></div>
            </div>
            
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="icon icon-check"></i>
                    </div>
                    <h3>Legal & Terpercaya</h3>
                    <p>Perusahaan travel resmi dengan izin operasional lengkap. Semua transaksi aman dan terjamin.</p>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="icon icon-phone"></i>
                    </div>
                    <h3>Layanan Pelanggan</h3>
                    <p>Tim customer service siap membantu Anda. Respon cepat untuk semua pertanyaan dan kebutuhan perjalanan.</p>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="icon icon-star"></i>
                    </div>
                    <h3>Paket Fleksibel</h3>
                    <p>Paket travel yang dapat disesuaikan dengan kebutuhan dan budget Anda untuk individu atau grup.</p>
                </div>
            </div>
        </div>
    </section>



    <!-- Showcase Layanan -->
    <section class="service-showcase" id="service-showcase">
        <div class="showcase-overlay">
            <div class="container">
                <div class="showcase-content">
                    <!-- Kolom kiri: Foto unggulan -->
                    <div class="showcase-images">
                        <div class="showcase-image-main">
                            <img src="cendana/showcase-main.jpg" alt="Layanan Profesional Cendana Travel" 
                                 onerror="this.src='https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'">
                        </div>
                        <div class="showcase-image-grid">
                            <div class="showcase-image-small">
                                <img src="cendana/showcase-office.jpg" alt="Kantor Cendana Travel" 
                                     onerror="this.src='https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80'">
                            </div>
                            <div class="showcase-image-small">
                                <img src="cendana/showcase-service.jpg" alt="Pelayanan Pelanggan" 
                                     onerror="this.src='https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80'">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kolom kanan: Narasi keunggulan -->
                    <div class="showcase-text">
                        <h2 class="showcase-title">Mengapa Memilih Cendana Travel?</h2>
                        
                        <div class="showcase-features">
                            <div class="feature-item">
                                <h3>Layanan Profesional dan Terpercaya</h3>
                                <p>Dengan izin resmi dan pengalaman bertahun-tahun, kami memberikan layanan travel yang dapat diandalkan untuk setiap perjalanan Anda.</p>
                            </div>
                            
                            <div class="feature-item">
                                <h3>Pengalaman Lebih dari 10 Tahun</h3>
                                <p>Sejak 2014, kami telah melayani ribuan pelanggan dengan dedikasi tinggi dan komitmen untuk memberikan pengalaman perjalanan terbaik.</p>
                            </div>
                            
                            <div class="feature-item">
                                <h3>Siap Melayani Ke Mana Pun Tujuan Anda</h3>
                                <p>Dari perjalanan domestik hingga internasional, kami siap mengatur semua kebutuhan transportasi dan akomodasi Anda.</p>
                            </div>
                        </div>
                        
                        <div class="showcase-cta">
                            <a href="galeri.php" class="btn-showcase">Lihat Galeri Kami</a>
                            <a href="pemesanan.php" class="btn-showcase-order">
                                <i class="icon icon-ticket"></i> Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="testimonials-header">
                <span class="section-label">TESTIMONI</span>
                <h2 class="testimonials-title"></h2>
                <p class="testimonials-subtitle">Pengalaman nyata dari pelanggan yang telah menggunakan layanan kami</p>
            </div>

            <div class="testimonials-wrapper">
                <button class="nav-btn nav-prev" onclick="testimonialsSlider.prev()">
                    <span>&lt;</span>
                </button>

                <div class="testimonials-container">
                    <div class="testimonials-track" id="testimonialsTrack">
                        <!-- Card 1 -->
                        <div class="testimonial-card">
                            <div class="card-avatar">
                                <div class="avatar" style="background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);">
                                    <span>E</span>
                                </div>
                            </div>
                            <h3 class="card-name">Eddy Irawan Batuna</h3>
                            <div class="card-rating">
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                            </div>
                            <p class="card-text">Salah satu biro perjalanan yang menyediakan ticket kapal serta pesawat, yang dilengkapi dengan jasa armada angkutan</p>
                        </div>

                        <!-- Card 2 -->
                        <div class="testimonial-card">
                            <div class="card-avatar">
                                <div class="avatar" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);">
                                    <span>A</span>
                                </div>
                            </div>
                            <h3 class="card-name">Ali Harsyah</h3>
                            <div class="card-rating">
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                            </div>
                            <p class="card-text">Respon cepat...meski cuma via WA...urusan lancar..jelas ...pelayanan baik n ramah...memuaskan</p>
                        </div>

                        <!-- Card 3 -->
                        <div class="testimonial-card">
                            <div class="card-avatar">
                                <div class="avatar" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                                    <span>A</span>
                                </div>
                            </div>
                            <h3 class="card-name">Aricco Excell</h3>
                            <div class="card-rating">
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                            </div>
                            <p class="card-text">pelayanan mantappp, kirim velg ke sangatta murahhh cepat sampaii. top markotop</p>
                        </div>

                        <!-- Card 4 -->
                        <div class="testimonial-card">
                            <div class="card-avatar">
                                <div class="avatar" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                                    <span>J</span>
                                </div>
                            </div>
                            <h3 class="card-name">Just4Share</h3>
                            <div class="card-rating">
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                            </div>
                            <p class="card-text">Sangat membantu untuk pengiriman paket area kaltim</p>
                        </div>

                        <!-- Card 5 -->
                        <div class="testimonial-card">
                            <div class="card-avatar">
                                <div class="avatar" style="background: linear-gradient(135deg, #9333ea 0%, #7e22ce 100%);">
                                    <span>A</span>
                                </div>
                            </div>
                            <h3 class="card-name">Agus Said Styagraha</h3>
                            <div class="card-rating">
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                            </div>
                            <p class="card-text">Beli tiket untuk pulang kampung gaess</p>
                        </div>

                        <!-- Card 6 -->
                        <div class="testimonial-card">
                            <div class="card-avatar">
                                <div class="avatar" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);">
                                    <span>B</span>
                                </div>
                            </div>
                            <h3 class="card-name">Bella Swan</h3>
                            <div class="card-rating">
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star"></i>
                            </div>
                            <p class="card-text">Bisa membeli berbagai macam tiket transportasi.. Mencakup darat. Udara. Laut tergantung buget pilihan anda..</p>
                        </div>

                        <!-- Card 7 -->
                        <div class="testimonial-card">
                            <div class="card-avatar">
                                <div class="avatar" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                    <span>S</span>
                                </div>
                            </div>
                            <h3 class="card-name">Sonny Lee Hutagalung</h3>
                            <div class="card-rating">
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star"></i>
                            </div>
                            <p class="card-text">Pilihan bagus untuk bepergian. Perusahaan yang sudah 20 tahun lebih menjadi agen perjalanan laut, darat dan udara...</p>
                        </div>

                        <!-- Card 8 -->
                        <div class="testimonial-card">
                            <div class="card-avatar">
                                <div class="avatar" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                                    <span>F</span>
                                </div>
                            </div>
                            <h3 class="card-name">Fakhrul Azmi</h3>
                            <div class="card-rating">
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star-fill"></i>
                                <i class="icon icon-star"></i>
                            </div>
                            <p class="card-text">Untuk kiriman paket ke melaknya luar biasa cepat, sayangnya tidak setiap hari hanya 2 kali seminggu...</p>
                        </div>
                    </div>
                </div>

                <button class="nav-btn nav-next" onclick="testimonialsSlider.next()">
                    <span>&gt;</span>
                </button>
            </div>

            <div class="testimonials-indicators" id="testimonialsIndicators"></div>
        </div>
    </section>

    <!-- How to Order Section -->
    <section class="how-to-order">
        <div class="container">
            <div class="section-header-center">
                <h2 class="section-title-dark">Cara Pesan Tiket</h2>
                <p class="section-subtitle-dark">Proses pemesanan yang mudah dan cepat dalam 4 langkah</p>
            </div>
            
            <div class="steps-container">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 10h-2V4h1V2H4v2h1v6H3a1 1 0 00-1 1v3a1 1 0 001 1h2v5a1 1 0 001 1h12a1 1 0 001-1v-5h2a1 1 0 001-1v-3a1 1 0 00-1-1zM7 4h10v6H7V4zm10 16H7v-5h10v5zm3-7h-1v-1a1 1 0 00-1-1H6a1 1 0 00-1 1v1H4v-2h16v2z"/>
                        </svg>
                    </div>
                    <h3>Pilih Tujuan</h3>
                    <p>Tentukan destinasi dan jadwal perjalanan Anda</p>
                </div>
                
                <div class="step-connector"></div>
                
                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>
                        </svg>
                    </div>
                    <h3>Hubungi Kami</h3>
                    <p>Chat via WhatsApp untuk konfirmasi ketersediaan</p>
                </div>
                
                <div class="step-connector"></div>
                
                <div class="step-item">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>
                        </svg>
                    </div>
                    <h3>Lakukan Pembayaran</h3>
                    <p>Transfer sesuai instruksi yang diberikan</p>
                </div>
                
                <div class="step-connector"></div>
                
                <div class="step-item">
                    <div class="step-number">4</div>
                    <div class="step-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22 10V6c0-1.11-.9-2-2-2H4c-1.1 0-1.99.89-1.99 2v4c1.1 0 1.99.9 1.99 2s-.89 2-2 2v4c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-4c-1.1 0-2-.9-2-2s.9-2 2-2zm-2-1.46c-1.19.69-2 1.99-2 3.46s.81 2.77 2 3.46V18H4v-2.54c1.19-.69 2-1.99 2-3.46 0-1.48-.8-2.77-1.99-3.46L4 6h16v2.54zM11 15h2v2h-2zm0-4h2v2h-2zm0-4h2v2h-2z"/>
                        </svg>
                    </div>
                    <h3>Terima Tiket</h3>
                    <p>Tiket dikirim setelah pembayaran dikonfirmasi</p>
                </div>
            </div>
            
            <div class="cta-center">
                <a href="pemesanan.php" class="btn-order-now">
                    <i class="icon icon-ticket"></i> Mulai Pesan Sekarang
                </a>
            </div>
        </div>
    </section>

    <script>
    const testimonialsSlider = {
        currentIndex: 0,
        itemsPerView: 3,
        totalItems: 8,
        
        init() {
            this.handleResize();
            this.updateView();
            this.createIndicators();
            window.addEventListener('resize', () => this.handleResize());
        },
        
        handleResize() {
            const width = window.innerWidth;
            if (width <= 576) {
                this.itemsPerView = 1;
            } else if (width <= 968) {
                this.itemsPerView = 2;
            } else {
                this.itemsPerView = 3;
            }
            this.currentIndex = Math.min(this.currentIndex, this.totalItems - this.itemsPerView);
            this.updateView();
            this.createIndicators();
        },
        
        updateView() {
            const track = document.getElementById('testimonialsTrack');
            if (!track) return;
            
            const cardWidth = 100 / this.itemsPerView;
            const offset = -(this.currentIndex * cardWidth);
            track.style.transform = `translateX(${offset}%)`;
            this.updateIndicators();
        },
        
        createIndicators() {
            const container = document.getElementById('testimonialsIndicators');
            if (!container) return;
            
            const maxIndex = this.totalItems - this.itemsPerView;
            container.innerHTML = '';
            
            for (let i = 0; i <= maxIndex; i++) {
                const dot = document.createElement('button');
                dot.className = 'dot';
                if (i === this.currentIndex) dot.classList.add('active');
                dot.onclick = () => this.goTo(i);
                container.appendChild(dot);
            }
        },
        
        updateIndicators() {
            const dots = document.querySelectorAll('.testimonials-indicators .dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === this.currentIndex);
            });
        },
        
        next() {
            const maxIndex = this.totalItems - this.itemsPerView;
            if (this.currentIndex < maxIndex) {
                this.currentIndex++;
                this.updateView();
            }
        },
        
        prev() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
                this.updateView();
            }
        },
        
        goTo(index) {
            this.currentIndex = index;
            this.updateView();
        }
    };
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => testimonialsSlider.init());
    } else {
        testimonialsSlider.init();
    }
    </script>

    <!-- Lokasi & Hubungi Kami -->
    <section class="location-contact-section" id="contact">
        <!-- Background dengan efek animasi -->
        <div class="contact-background">
            <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
                <div class="shape shape-4"></div>
            </div>
        </div>
        
        <div class="container">
            <div class="section-header-center">
                <span class="section-label">LOKASI & KONTAK</span>
                <h2 class="section-title-dark">Kunjungi atau Hubungi Kami</h2>
                <p class="section-subtitle-dark">Temukan kantor kami atau hubungi langsung untuk informasi lebih lanjut</p>
            </div>

            <!-- Google Maps -->
            <div class="location-maps">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d546.8050903811442!2d117.12205033833523!3d-0.4984549630771363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67efeea5fd683%3A0x8810a875396e82ea!2sCendana%20MP%20Travel!5e1!3m2!1sid!2sid!4v1763308559407!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <!-- Contact Info Cards -->
            <div class="contact-cards-grid">
                <div class="contact-info-card">
                    <div class="contact-card-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>
                        </svg>
                    </div>
                    <h3>WhatsApp</h3>
                    <p><?php echo htmlspecialchars($companyInfoData['whatsapp']); ?></p>
                    <a href="kontak.php" class="contact-card-link">Chat Sekarang →</a>
                </div>

                <div class="contact-info-card">
                    <div class="contact-card-icon">
                        <i class="icon icon-route"></i>
                    </div>
                    <h3>Alamat Kantor</h3>
                    <p><?php echo nl2br(htmlspecialchars(str_replace('<br>', "\n", $companyInfoData['address']))); ?></p>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=-0.4984549630771363,117.12205033833523" class="contact-card-link" target="_blank">Dapatkan Petunjuk Arah →</a>
                </div>

                <div class="contact-info-card">
                    <div class="contact-card-icon">
                        <i class="icon icon-info"></i>
                    </div>
                    <h3>Jam Operasional</h3>
                    <p><?php echo htmlspecialchars($companyInfoData['hours']); ?></p>
                    <a href="galeri.php" class="contact-card-link">Lihat Galeri →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <!-- Section 1: Tentang Perusahaan -->
                <div class="footer-section">
                    <h3><?php echo htmlspecialchars($companyInfoData['name']); ?></h3>
                    <p><?php echo htmlspecialchars($companyInfoData['description']); ?></p>
                    
                    <!-- Statistik Perusahaan -->
                    <div class="footer-stats">
                        <div class="stat-item">
                            <strong>10+</strong>
                            <span>Tahun Pengalaman</span>
                        </div>
                        <div class="stat-item">
                            <strong>1000+</strong>
                            <span>Pelanggan Puas</span>
                        </div>
                    </div>
                </div>
                
                <!-- Section 2: Menu -->
                <div class="footer-section">
                    <h3>Menu</h3>
                    <ul>
                        <li><a href="index.php"><i class="icon icon-home"></i> Beranda</a></li>
                        <li><a href="pemesanan.php"><i class="icon icon-ticket"></i> Pemesanan</a></li>
                        <li><a href="galeri.php"><i class="icon icon-camera"></i> Galeri</a></li>
                        <li><a href="kontak.php"><i class="icon icon-phone"></i> Kontak</a></li>
                        <li><a href="faq.php"><i class="icon icon-question"></i> FAQ</a></li>
                    </ul>
                </div>
                
                <!-- Section 3: Layanan -->
                <div class="footer-section">
                    <h3>Layanan Kami</h3>
                    <ul>
                        <li><a href="pemesanan.php"><i class="icon icon-plane"></i> Tiket Pesawat</a></li>
                        <li><a href="pemesanan.php"><i class="icon icon-ship"></i> Tiket Kapal</a></li>
                        <li><a href="pemesanan.php"><i class="icon icon-bus"></i> Tiket Bus</a></li>
                    </ul>
                </div>
                
                <!-- Section 4: Kontak & Social Media -->
                <div class="footer-section">
                    <h3>Hubungi Kami</h3>
                    <div class="contact-info">
                        <p><i class="icon icon-whatsapp"></i> <?php echo htmlspecialchars($companyInfoData['whatsapp']); ?></p>
                        <p><i class="icon icon-email"></i> <?php echo htmlspecialchars($companyInfoData['email']); ?></p>
                        <p><i class="icon icon-route"></i> <?php echo nl2br(htmlspecialchars(str_replace('<br>', "\n", $companyInfoData['address']))); ?></p>
                        <p><i class="icon icon-info"></i> <?php echo htmlspecialchars($companyInfoData['hours']); ?></p>
                    </div>
                    
                    <!-- Media Sosial -->
                    <div class="social-media">
                        <h4>Ikuti Kami</h4>
                        <div class="social-links">
                            <a href="https://wa.me/<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>" class="social-link" target="_blank" title="WhatsApp"><i class="icon icon-whatsapp"></i></a>
                            <a href="https://instagram.com/<?php echo htmlspecialchars(str_replace('@', '', $companyInfoData['instagram'])); ?>" class="social-link" target="_blank" title="Instagram"><i class="icon icon-camera"></i></a>
                            <a href="mailto:<?php echo htmlspecialchars($companyInfoData['email']); ?>" class="social-link" title="Email"><i class="icon icon-email"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom: Copyright & Info -->
            <div class="footer-bottom">
                <p>&copy; 2024 <?php echo htmlspecialchars($companyInfoData['name']); ?>. All rights reserved.</p>
                <p style="margin-top: 10px; font-size: 0.9rem; opacity: 0.8;">
                    <i class="icon icon-graduation-cap"></i>
                    Website ini dibuat oleh Mahasiswa Informatika Universitas Mulawarman
                    sebagai syarat mata kuliah Pemrograman Web
                </p>
                
                <!-- Ikon Kunci Admin (Floating Button) -->
                <!-- Klik ikon kunci untuk akses admin atau gunakan Ctrl+Shift+A -->
                <div class="admin-access" onclick="showAdminLogin()" title="Admin Login (Ctrl+Shift+A)">
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
                    <button class="btn-admin-cancel" onclick="closeAdminLogin()">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>




    <script src="config.js"></script>
    <script src="script.js"></script>
</body>

</html>
<?php

?>