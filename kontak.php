<?php
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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - <?php echo htmlspecialchars($companyName); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="icons.css">
    <link rel="stylesheet" href="kontak-dynamic.css">
</head>
<body class="page-kontak">
    <!-- Header Navigation -->
    <header>
        <div class="container header-container">
            <a href="index.php" class="logo"><?php echo htmlspecialchars($companyName); ?></a>
            
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="pemesanan.php">Pemesanan</a></li>
                    <li><a href="galeri.php">Galeri</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="kontak.php" class="active">Kontak</a></li>
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

    <!-- New Hero Banner + Overlapping Two Column Layout (Matches Screenshot 3) -->
    <section class="page-hero-standard" <?php if (!empty($homepageSettings['kontak_hero_background'])): ?>style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('uploads/<?php echo htmlspecialchars($homepageSettings['kontak_hero_background']); ?>'); background-size: cover; background-position: center;"<?php endif; ?>>
        <div class="container">
            <div class="page-hero-content">
                <h1 class="page-hero-title"><?php echo htmlspecialchars($homepageSettings['kontak_hero_title'] ?? 'Hubungi Kami'); ?></h1>
                <p class="page-hero-subtitle"><?php echo htmlspecialchars($homepageSettings['kontak_hero_description'] ?? 'Kami siap membantu kebutuhan perjalanan Anda'); ?></p>
            </div>
        </div>
    </section>
    <section class="contact-section-wrapper">
        <div class="container">
            <!-- Glass / White Wrapper that contains both columns -->
            <div class="contact-container-glass">
                <div class="contact-content-grid">
                    <!-- Left: Consolidated Contact Info Panel -->
                    <aside class="contact-panel animate-on-scroll">
                        <h2 class="panel-title">Informasi Kontak</h2>
                        <div class="contact-panel-item">
                            <div class="contact-panel-icon"><i class="icon icon-whatsapp"></i></div>
                            <div class="contact-panel-text">
                                <h3>WhatsApp</h3>
                                <p><a href="https://wa.me/<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>" target="_blank">+<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?></a></p>
                            </div>
                        </div>
                        <div class="contact-panel-item">
                            <div class="contact-panel-icon"><i class="icon icon-email"></i></div>
                            <div class="contact-panel-text">
                                <h3>Email</h3>
                                <p><a href="mailto:<?php echo htmlspecialchars($companyInfoData['email']); ?>"><?php echo htmlspecialchars($companyInfoData['email']); ?></a></p>
                            </div>
                        </div>
                        <div class="contact-panel-item">
                            <div class="contact-panel-icon"><i class="icon icon-location"></i></div>
                            <div class="contact-panel-text">
                                <h3>Alamat Kantor</h3>
                                <p><?php echo $companyInfoData['address']; ?></p>
                            </div>
                        </div>
                        <div class="contact-panel-item">
                            <div class="contact-panel-icon"><i class="icon icon-instagram"></i></div>
                            <div class="contact-panel-text">
                                <h3>Instagram</h3>
                                <?php 
                                $instagramUsername = str_replace('@', '', htmlspecialchars($companyInfoData['instagram']));
                                $instagramDisplay = (strpos($companyInfoData['instagram'], '@') === 0) ? $companyInfoData['instagram'] : '@' . $companyInfoData['instagram'];
                                ?>
                                <p><a href="https://instagram.com/<?php echo $instagramUsername; ?>" target="_blank"><?php echo htmlspecialchars($instagramDisplay); ?></a></p>
                            </div>
                        </div>
                        <?php if (!empty($companyInfoData['tiktok'])): ?>
                        <div class="contact-panel-item">
                            <div class="contact-panel-icon"><i class="icon icon-tiktok"></i></div>
                            <div class="contact-panel-text">
                                <h3>TikTok</h3>
                                <?php 
                                $tiktokUsername = str_replace('@', '', htmlspecialchars($companyInfoData['tiktok']));
                                $tiktokDisplay = (strpos($companyInfoData['tiktok'], '@') === 0) ? $companyInfoData['tiktok'] : '@' . $companyInfoData['tiktok'];
                                ?>
                                <p><a href="https://tiktok.com/@<?php echo $tiktokUsername; ?>" target="_blank"><?php echo htmlspecialchars($tiktokDisplay); ?></a></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </aside>

                    <!-- Right: Modern Form Card -->
                    <article class="contact-form-card animate-on-scroll">
                        <h2 class="form-card-title">Kirim Pesan</h2>
                        <form id="contactForm" onsubmit="handleContactForm(event)">
                            <div class="form-group-modern">
                                <label for="name">Nama Lengkap <span class="required">*</span></label>
                                <input type="text" id="name" name="name" required placeholder="Masukkan nama lengkap Anda">
                            </div>
                            <div class="form-row">
                                <div class="form-group-modern">
                                    <label for="email">Email <span class="required">*</span></label>
                                    <input type="email" id="email" name="email" required placeholder="email@contoh.com">
                                </div>
                                <div class="form-group-modern">
                                    <label for="phone">Nomor HP <span class="required">*</span></label>
                                    <input type="tel" id="phone" name="phone" required placeholder="08xx xxxx xxxx">
                                </div>
                            </div>
                            <div class="form-group-modern">
                                <label for="message">Pesan / Pertanyaan <span class="required">*</span></label>
                                <textarea id="message" name="message" required placeholder="Tulis pesan atau pertanyaan Anda di sini..."></textarea>
                            </div>
                            <button type="submit" class="btn-submit-modern">
                                <i class="icon icon-send"></i>
                                Kirim Pesan
                            </button>
                        </form>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section - Full Width Below -->
    <section class="map-section-full">
        <div class="container">
            <div class="map-section-header animate-on-scroll">
                <h2>Lokasi Kantor Kami</h2>
                <p>Kunjungi kantor kami untuk konsultasi langsung</p>
            </div>

            <!-- Full Width Map -->
            <div class="map-container-large animate-on-scroll">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3968.8158906435345!2d117.1451!3d-0.5144!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df68d1e0a0a0a0b%3A0x0!2sCendana%20Travel!5e0!3m2!1sid!2sid!4v1234567890" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
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
        function handleContactForm(e) {
            e.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const message = document.getElementById('message').value;

            const fullMessage = `*FORM KONTAK - CV. CENDANA TRAVEL*

Nama: ${name}
Email: ${email}
Nomor HP: ${phone}

Pesan:
${message}

---
Dikirim dari halaman Kontak
`;

            const waNumber = '<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>';
            const waURL = `https://wa.me/${waNumber}?text=${encodeURIComponent(fullMessage)}`;
            
            window.open(waURL, '_blank');
            document.getElementById('contactForm').reset();
        }
    </script>
    <script src="config.js"></script>
    <script src="script.js"></script>
    <script src="kontak-animations.js"></script>
</body>
</html>

<?php
if (isset($conn)) {
    $conn->close();
}
?>
