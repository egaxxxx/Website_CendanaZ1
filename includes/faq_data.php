<?php
// Data FAQ yang bisa diakses dari berbagai halaman

function getFaqData() {
    return [
        [
            'category' => 'Pemesanan',
            'items' => [
                [
                    'question' => 'Bagaimana cara memesan tiket?',
                    'answer' => 'Anda dapat memesan tiket melalui website kami dengan mengklik tombol "Pesan Sekarang" pada layanan yang Anda pilih. Setelah itu, isi form pemesanan dan klik "Kirim via WhatsApp". Anda akan diarahkan ke WhatsApp kami untuk konfirmasi dan pembayaran.'
                ],
                [
                    'question' => 'Mengapa menggunakan WhatsApp untuk pemesanan?',
                    'answer' => 'Kami menggunakan WhatsApp karena: (1) <strong>Keamanan</strong> - komunikasi terenkripsi end-to-end, (2) <strong>Kemudahan</strong> - Anda bisa chat kapan saja tanpa install aplikasi khusus, (3) <strong>Transparansi</strong> - semua percakapan tersimpan sebagai bukti, (4) <strong>Responsif</strong> - tim kami siap membalas dengan cepat.'
                ],
                [
                    'question' => 'Berapa lama proses konfirmasi pemesanan?',
                    'answer' => 'Konfirmasi pemesanan biasanya dilakukan dalam waktu 5-15 menit setelah Anda mengirim data via WhatsApp. Untuk pemesanan di luar jam kerja, konfirmasi akan dilakukan maksimal 1 jam. Tim kami siap melayani 24/7.'
                ],
                [
                    'question' => 'Apakah bisa melakukan perubahan atau pembatalan tiket?',
                    'answer' => 'Perubahan dan pembatalan tiket dapat dilakukan sesuai kebijakan maskapai/operator transportasi. Hubungi customer service kami via WhatsApp untuk bantuan reschedule atau refund. Biaya perubahan/pembatalan mengikuti aturan masing-masing penyedia layanan.'
                ],
                [
                    'question' => 'Berapa lama sebelum keberangkatan harus pesan?',
                    'answer' => 'Untuk pesawat, sebaiknya pesan minimal H-1 sebelum keberangkatan. Untuk keberangkatan hari yang sama (H-0), hubungi kami via WhatsApp untuk cek ketersediaan. Semakin cepat memesan, semakin banyak pilihan dan harga yang lebih baik.'
                ]
            ]
        ],
        [
            'category' => 'Pembayaran',
            'items' => [
                [
                    'question' => 'Metode pembayaran apa saja yang tersedia?',
                    'answer' => 'Kami menerima pembayaran melalui: Transfer Bank (BCA, Mandiri, BRI, BNI), E-Wallet (OVO, GoPay, DANA, LinkAja), dan Cash (di kantor kami). Setelah konfirmasi via WhatsApp, kami akan mengirimkan detail rekening/nomor e-wallet untuk pembayaran.'
                ],
                [
                    'question' => 'Kapan batas waktu pembayaran?',
                    'answer' => 'Batas waktu pembayaran adalah 24 jam setelah konfirmasi pemesanan. Untuk keberangkatan kurang dari 3 hari, pembayaran harus dilakukan dalam 6 jam. Kami akan kirim reminder via WhatsApp sebelum batas waktu berakhir.'
                ],
                [
                    'question' => 'Apakah harga sudah termasuk bagasi?',
                    'answer' => 'Harga yang tertera adalah harga dasar tiket. Untuk pesawat, bagasi cabin biasanya sudah termasuk (7kg), sedangkan bagasi check-in tergantung kebijakan maskapai. Kami akan informasikan detail bagasi saat konfirmasi pemesanan via WhatsApp.'
                ],
                [
                    'question' => 'Apakah ada biaya tambahan?',
                    'answer' => 'Tidak ada biaya tersembunyi. Harga yang kami sebutkan adalah harga final. Biaya tambahan hanya ada jika Anda request layanan ekstra seperti antar jemput, asuransi perjalanan, atau extra bagasi. Semua akan dijelaskan transparan sebelum pembayaran.'
                ]
            ]
        ],
        [
            'category' => 'Layanan',
            'items' => [
                [
                    'question' => 'Apa saja jenis transportasi yang disediakan?',
                    'answer' => 'Kami menyediakan: (1) <strong>Tiket Pesawat</strong> - berbagai maskapai domestik seperti Lion Air, Garuda, Citilink, AirAsia, dll, (2) <strong>Tiket Kapal</strong> - untuk rute antar pulau dengan Pelni dan kapal feri, (3) <strong>Tiket Bus</strong> - untuk perjalanan darat antar kota dengan berbagai PO.'
                ],
                [
                    'question' => 'Apakah tersedia layanan antar jemput?',
                    'answer' => 'Ya, tersedia layanan antar jemput dari rumah ke bandara/terminal dengan kendaraan nyaman dan sopir berpengalaman. Layanan ini bisa dipesan bersamaan dengan tiket. Harga bervariasi tergantung jarak dan jenis kendaraan. Hubungi kami via WhatsApp untuk info lebih lanjut.'
                ],
                [
                    'question' => 'Apakah layanan customer service 24/7?',
                    'answer' => 'Ya, customer service kami siap melayani 24 jam sehari, 7 hari seminggu melalui WhatsApp di 085821841529. Untuk kunjungan langsung ke kantor, kami buka Senin-Minggu pukul 08.00-22.00 WIB di Jl. Cendana No.8, Samarinda.'
                ],
                [
                    'question' => 'Apakah bisa pesan untuk grup/rombongan?',
                    'answer' => 'Tentu! Kami melayani pemesanan grup mulai dari 10 orang ke atas dengan harga spesial. Untuk rombongan, kami bantu koordinasi mulai dari pemesanan tiket, hotel, hingga transportasi lokal. Hubungi kami untuk penawaran khusus grup.'
                ]
            ]
        ],
        [
            'category' => 'Umum',
            'items' => [
                [
                    'question' => 'Dimana lokasi kantor Cendana Travel?',
                    'answer' => 'Kantor kami berlokasi di Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang, Kota Samarinda, Kalimantan Timur 75127. Buka setiap hari pukul 08.00-22.00 WIB. Anda bisa lihat lokasi di Google Maps melalui halaman Kontak kami.'
                ],
                [
                    'question' => 'Berapa lama pengalaman Cendana Travel?',
                    'answer' => 'Cendana Travel telah berpengalaman lebih dari 10 tahun melayani kebutuhan perjalanan pelanggan. Kami memulai dari lokasi sederhana dan kini berkembang dengan kantor yang lebih besar serta jaringan luas di berbagai destinasi.'
                ],
                [
                    'question' => 'Apakah Cendana Travel terpercaya?',
                    'answer' => 'Ya, kami adalah agen travel resmi dan terdaftar. Kami telah melayani ribuan pelanggan dengan rating kepuasan tinggi. Semua transaksi tercatat dan aman. Anda bisa cek testimoni pelanggan kami atau kunjungi kantor kami langsung.'
                ],
                [
                    'question' => 'Bagaimana cara menghubungi customer service?',
                    'answer' => 'Anda dapat menghubungi kami melalui: (1) WhatsApp: 085821841529 (24/7), (2) Email: info@cendanatravel.com, (3) Datang langsung ke kantor di Jl. Cendana No.8, Samarinda (08.00-22.00 WIB). Tim kami siap membantu Anda.'
                ]
            ]
        ]
    ];
}

// Fungsi untuk mendapatkan FAQ berdasarkan kategori
function getFaqByCategory($category) {
    $allFaq = getFaqData();
    foreach ($allFaq as $faqGroup) {
        if ($faqGroup['category'] === $category) {
            return $faqGroup['items'];
        }
    }
    return [];
}
?>
