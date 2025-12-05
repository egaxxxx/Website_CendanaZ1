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
            <a href="index.php" class="logo"><?php echo htmlspecialchars($companyInfoData['name']); ?></a>
            <nav>
                'answer' => 'Konfirmasi pemesanan biasanya dilakukan dalam waktu 1-2 jam kerja setelah pembayaran diterima. Untuk pemesanan mendesak, kami dapat melakukan konfirmasi lebih cepat. Tim customer service kami akan mengirimkan konfirmasi melalui WhatsApp atau email.'
            ],
            [
                'question' => 'Apakah bisa melakukan perubahan atau pembatalan tiket?',
                'answer' => 'Perubahan dan pembatalan tiket dapat dilakukan sesuai dengan kebijakan maskapai/operator transportasi. Setiap maskapai memiliki aturan berbeda terkait perubahan jadwal dan pembatalan. Kami akan membantu Anda memahami kebijakan yang berlaku dan memproses perubahan/pembatalan sesuai prosedur.'
            ]
        ]
    ],
    [
        'category' => 'Pembayaran',
        'items' => [
            [
                'question' => 'Metode pembayaran apa saja yang diterima?',
                'answer' => 'Kami menerima pembayaran melalui transfer bank (BCA, Mandiri, BRI, BNI), e-wallet (OVO, GoPay, DANA, LinkAja), dan tunai di kantor. Untuk pemesanan online, pembayaran dapat dilakukan melalui transfer bank atau e-wallet yang akan kami kirimkan detailnya setelah konfirmasi pemesanan.'
            ],
            [
                'question' => 'Kapan batas waktu pembayaran setelah pemesanan?',
                'answer' => 'Batas waktu pembayaran biasanya 24 jam setelah pemesanan dikonfirmasi. Untuk pemesanan dengan jadwal keberangkatan kurang dari 3 hari, pembayaran harus dilakukan dalam waktu 6 jam. Kami akan mengirimkan reminder melalui WhatsApp sebelum batas waktu pembayaran habis.'
            ],
            [
                'question' => 'Apakah ada biaya tambahan selain harga tiket?',
                'answer' => 'Harga yang tertera sudah termasuk harga tiket dasar. Biaya tambahan yang mungkin dikenakan antara lain: biaya admin (jika ada), asuransi perjalanan (opsional), dan layanan tambahan seperti antar jemput atau handling bagasi. Semua biaya tambahan akan diinformasikan secara transparan sebelum pembayaran.'
            ]
        ]
    ],
    [
        'category' => 'Layanan',
        'items' => [
            [
                'question' => 'Apa saja jenis transportasi yang disediakan?',
                'answer' => 'Kami menyediakan layanan pemesanan untuk berbagai jenis transportasi: (1) Tiket Pesawat - berbagai maskapai domestik dan internasional, (2) Tiket Kapal - untuk rute antar pulau, (3) Tiket Bus - untuk perjalanan darat, dan (4) Sewa Mobil - untuk perjalanan pribadi atau grup.'
            ],
            [
                'question' => 'Apakah tersedia layanan antar jemput?',
                'answer' => 'Ya, kami menyediakan layanan antar jemput dari rumah/bandara/terminal dengan kendaraan yang nyaman dan sopir berpengalaman. Layanan ini dapat dipesan bersamaan dengan tiket atau secara terpisah. Harga bervariasi tergantung jarak dan jenis kendaraan yang dipilih.'
            ],
            [
                'question' => 'Apakah ada layanan customer service 24/7?',
                'answer' => 'Ya, tim customer service kami siap membantu Anda 24 jam sehari, 7 hari seminggu melalui WhatsApp di nomor 085821841529. Kami juga dapat dihubungi melalui email di info@cendanatravel.com. Untuk kunjungan langsung, kantor kami buka setiap hari pukul 08.00 - 22.00 WIB.'
            ],
            [
                'question' => 'Apakah tersedia asuransi perjalanan?',
                'answer' => 'Ya, kami menyediakan asuransi perjalanan komprehensif yang melindungi Anda selama bepergian. Asuransi ini mencakup perlindungan kesehatan, kehilangan bagasi, dan pembatalan perjalanan. Detail lengkap dan premi akan diinformasikan saat pemesanan.'
            ]
        ]
    ],
    [
        'category' => 'Umum',
        'items' => [
            [
                'question' => 'Dimana lokasi kantor Cendana Travel?',
                'answer' => 'Kantor kami berlokasi di Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur 75127. Kami buka setiap hari pukul 08.00 - 22.00 WIB. Anda juga dapat melihat lokasi kami di Google Maps melalui link yang tersedia di halaman Kontak.'
            ],
            [
                'question' => 'Berapa lama pengalaman Cendana Travel di industri travel?',
                'answer' => 'Cendana Travel telah berpengalaman lebih dari 10 tahun dalam melayani kebutuhan perjalanan pelanggan. Kami memulai dari lokasi sederhana dan kini telah berkembang dengan kantor cabang serta jaringan yang luas di berbagai destinasi.'
            ],
            [
                'question' => 'Bagaimana cara menghubungi Cendana Travel?',
                'answer' => 'Anda dapat menghubungi kami melalui: (1) WhatsApp: 085821841529 (24/7), (2) Email: info@cendanatravel.com, (3) Instagram: @cendanatravel_official, atau (4) Kunjungan langsung ke kantor kami di Jl. Cendana No.8, Samarinda. Tim kami siap membantu Anda kapan saja.'
            ],
            [
                'question' => 'Apakah Cendana Travel memiliki izin resmi?',
                'answer' => 'Ya, Cendana Travel adalah perusahaan travel resmi dan terpercaya dengan izin operasional lengkap. Semua transaksi yang dilakukan aman dan terjamin kelegalannya. Kami berkomitmen memberikan layanan terbaik dengan standar profesional tinggi.'
            ]
        ]
    ]
];
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
            <a href="index.php" class="logo"><?php echo htmlspecialchars($companyInfoData['name']); ?></a>
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="pemesanan.php">Pemesanan</a></li>
                    <li><a href="galeri.php">Galeri</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                    <li><a href="faq.php" class="active">FAQ</a></li>
                </ul>
            </nav>
            <div class="header-controls">
                <a href="https://wa.me/<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>" class="wa-header-btn" target="_blank" title="Hubungi via WhatsApp">
                    <i class="icon icon-whatsapp"></i>
                    <span>WhatsApp</span>
                </a>
                <button class="dark-mode-toggle" onclick="ubahModeGelap()" title="Ubah Mode Gelap/Terang">
                    <i class="icon icon-moon"></i>
                </button>
                <div class="mobile-menu" title="Menu">
                    <i class="icon icon-menu"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Pertanyaan yang Sering Diajukan</h1>
            <p>Temukan jawaban untuk pertanyaan umum tentang layanan dan pemesanan di Cendana Travel</p>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <!-- Search Box -->
            <div class="faq-search-container">
                <div class="faq-search-box">
                    <i class="icon icon-search"></i>
                    <input type="text" id="faqSearch" placeholder="Cari pertanyaan atau kata kunci...">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="faq-categories">
                <?php 
                $isFirst = true;
                foreach ($faqData as $category): 
                ?>
                    <button class="faq-category-btn <?php echo $isFirst ? 'active' : ''; ?>" data-category="<?php echo strtolower(str_replace(' ', '-', $category['category'])); ?>">
                        <?php echo htmlspecialchars($category['category']); ?>
                    </button>
                <?php 
                    $isFirst = false;
                endforeach; 
                ?>
            </div>

            <!-- FAQ Accordion -->
            <div class="faq-accordion" id="faqAccordion">
                <?php foreach ($faqData as $category): ?>
                    <div class="faq-category-group" data-category="<?php echo strtolower(str_replace(' ', '-', $category['category'])); ?>">
                        <h2 class="faq-category-title">
                            <i class="icon icon-info"></i>
                            <?php echo htmlspecialchars($category['category']); ?>
                        </h2>
                        <?php foreach ($category['items'] as $index => $item): ?>
                            <div class="faq-item">
                                <button class="faq-question">
                                    <span class="faq-question-text">
                                        <i class="icon icon-question-circle"></i>
                                        <?php echo htmlspecialchars($item['question']); ?>
                                    </span>
                                    <i class="icon icon-chevron-down faq-chevron"></i>
                                </button>
                                <div class="faq-answer">
                                    <div class="faq-answer-content">
                                        <i class="icon icon-check"></i>
                                        <p><?php echo nl2br(htmlspecialchars($item['answer'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- No Results Message -->
            <div class="faq-no-results" id="faqNoResults" style="display: none;">
                <i class="icon icon-exclamation-triangle"></i>
                <p>Tidak ada pertanyaan yang ditemukan</p>
                <p>Coba gunakan kata kunci lain atau <a href="kontak.php">hubungi kami</a> untuk bantuan lebih lanjut.</p>
            </div>

            <!-- Contact CTA -->
            <div class="faq-contact-cta">
                <h3>Masih ada pertanyaan?</h3>
                <p>Tim customer service kami siap membantu Anda 24/7</p>
                <div class="faq-cta-buttons">
                    <a href="https://wa.me/<?php echo htmlspecialchars($companyInfoData['whatsapp']); ?>" class="btn-faq-wa" target="_blank">
                        <i class="icon icon-whatsapp"></i> Chat WhatsApp
                    </a>
                    <a href="kontak.php" class="btn-faq-contact">
                        <i class="icon icon-phone"></i> Hubungi Kami
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
                        <li><a href="index.php"><i class="icon icon-home"></i> Beranda</a></li>
                        <li><a href="pemesanan.php"><i class="icon icon-ticket"></i> Pemesanan</a></li>
                        <li><a href="galeri.php"><i class="icon icon-camera"></i> Galeri</a></li>
                        <li><a href="kontak.php"><i class="icon icon-phone"></i> Kontak</a></li>
                        <li><a href="faq.php"><i class="icon icon-question"></i> FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Hubungi Kami</h3>
                    <p><i class="icon icon-whatsapp"></i> <?php echo htmlspecialchars($companyInfoData['whatsapp']); ?></p>
                    <p><i class="icon icon-email"></i> <?php echo htmlspecialchars($companyInfoData['email']); ?></p>
                    <p><i class="icon icon-route"></i> <?php echo nl2br(htmlspecialchars(str_replace('<br>', "\n", $companyInfoData['address']))); ?></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 <?php echo htmlspecialchars($companyInfoData['name']); ?>. All rights reserved.</p>
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

    <script src="config.js"></script>
    <script src="script.js"></script>
    <script src="faq.js"></script>
</body>
</html>

