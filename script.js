// Variabel global
let dataTransportasi = {};
let dataFasilitas = [];
let transportTypesData = [];
let companyInfoData = {};

// Muat data dari local storage
function muatDataDariPenyimpanan() {
    const versiSaatIni = '2.0';
    const versiTersimpan = localStorage.getItem('dataVersion');

    if (versiTersimpan !== versiSaatIni) {
        localStorage.removeItem('companyInfoData');
        localStorage.setItem('dataVersion', versiSaatIni);
        console.log('Data diperbarui ke versi', versiSaatIni);
    }

    // muat data transportasi
    const dataTransportasiTersimpan = localStorage.getItem('dataTransportasi');
    if (dataTransportasiTersimpan) {
        try {
            dataTransportasi = JSON.parse(dataTransportasiTersimpan);
        } catch (error) {
            console.error('Error saat memuat data:', error);
            dataTransportasi = DEFAULT_TRANSPORT_DATA;
        }
    } else {
        dataTransportasi = DEFAULT_TRANSPORT_DATA;
    }

    // muat data fasilitas
    const dataFasilitasTersimpan = localStorage.getItem('dataFasilitas');
    if (dataFasilitasTersimpan) {
        try {
            dataFasilitas = JSON.parse(dataFasilitasTersimpan);
        } catch (error) {
            console.error('Error saat memuat data:', error);
            dataFasilitas = DEFAULT_FACILITIES_DATA;
        }
    } else {
        dataFasilitas = DEFAULT_FACILITIES_DATA;
    }

    // muat data jenis transportasi
    const dataJenisTransportasiTersimpan = localStorage.getItem('transportTypesData');
    if (dataJenisTransportasiTersimpan) {
        try {
            transportTypesData = JSON.parse(dataJenisTransportasiTersimpan);
        } catch (error) {
            console.error('Error saat memuat data:', error);
            transportTypesData = DEFAULT_TRANSPORT_TYPES;
        }
    } else {
        transportTypesData = DEFAULT_TRANSPORT_TYPES;
    }

    // muat informasi perusahaan
    companyInfoData = COMPANY_CONFIG;
    localStorage.setItem('companyInfoData', JSON.stringify(companyInfoData));
}


// Simpan data ke local storage
function simpanDataKePenyimpanan() {
    try {
        localStorage.setItem('dataTransportasi', JSON.stringify(dataTransportasi));
        localStorage.setItem('dataFasilitas', JSON.stringify(dataFasilitas));
        localStorage.setItem('transportTypesData', JSON.stringify(transportTypesData));
        localStorage.setItem('companyInfoData', JSON.stringify(companyInfoData));
        console.log('Data berhasil disimpan');
    } catch (error) {
        console.error('Error saat menyimpan data:', error);
        alert('Gagal menyimpan data. Pastikan browser mendukung localStorage.');
    }
}


// Kirim pesan via WhatsApp
function pesanViaWhatsApp(namaProduk) {
    const nomorWhatsApp = companyInfoData.whatsapp || "6282152069585";
    let pesan;

    // cek format pesan
    if (typeof namaProduk === 'string' && namaProduk.includes('dari')) {
        pesan = namaProduk;
    } else {
        // Buat pesan default
        pesan = `Halo, saya ingin memesan tiket: ${namaProduk}. Bisa tolong berikan informasi lebih lanjut?`;
    }

    // Encode pesan untuk URL (mengganti spasi dan karakter khusus)
    const pesanTerencode = encodeURIComponent(pesan);
    const urlWhatsApp = `https://wa.me/${nomorWhatsApp}?text=${pesanTerencode}`;

    // Buka WhatsApp di tab baru
    window.open(urlWhatsApp, '_blank');
}

// Handle form booking WhatsApp
function handleWhatsAppBooking(event) {
    event.preventDefault();

    // ambil data dari form
    const origin = document.getElementById('origin').value.trim();
    const destination = document.getElementById('destination').value.trim();

    if (!origin || !destination) {
        alert('Mohon lengkapi kota asal dan tujuan perjalanan!');
        return;
    }
    const pesan = `Halo, saya ingin memesan tiket perjalanan:

Dari: ${origin}
Ke: ${destination}

Mohon informasi jadwal, harga, dan ketersediaan tiket. Terima kasih!`;

    const nomorWhatsApp = companyInfoData.whatsapp || "6285821841529";
    const pesanTerencode = encodeURIComponent(pesan);
    const urlWhatsApp = `https://wa.me/${nomorWhatsApp}?text=${pesanTerencode}`;

    // Buka WhatsApp di tab baru
    window.open(urlWhatsApp, '_blank');

    // Reset form setelah submit
    document.getElementById('origin').value = '';
    document.getElementById('destination').value = '';

    console.log('Form booking berhasil disubmit');
}


/**
 *  * FUNGSI: MUAT DAN TAMPILKAN FASILITAS
 *  * Fungsi ini menampilkan semua fasilitas ke halaman website
 * Data diambil dari variabel global dataFasilitas
 */
function muatDanTampilkanFasilitas() {
    // Cari elemen kontainer untuk menampilkan fasilitas
    const kontainerFasilitas = document.getElementById('destinations-grid');

    // Jika kontainer tidak ditemukan, hentikan fungsi
    if (!kontainerFasilitas) {
        console.warn('⚠️ Kontainer fasilitas tidak ditemukan');
        return;
    }

    // Kosongkan kontainer terlebih dahulu
    kontainerFasilitas.innerHTML = '';

    // Loop melalui setiap fasilitas dan buat card-nya
    dataFasilitas.forEach((fasilitas) => {
        // Buat elemen div untuk card fasilitas
        const kartuFasilitas = document.createElement('div');
        kartuFasilitas.className = 'destination-card facility-card';

        // Isi konten card dengan data fasilitas
        kartuFasilitas.innerHTML = `
            <div class="destination-image">
                <img src="${fasilitas.image}" alt="${fasilitas.name}" loading="lazy">
            </div>
            <div class="destination-content">
                <h3 class="destination-title">${fasilitas.name}</h3>
                <p class="destination-description">${fasilitas.description}</p>
            </div>
        `;

        // Tambahkan card ke kontainer
        kontainerFasilitas.appendChild(kartuFasilitas);
    });

    console.log(`${dataFasilitas.length} fasilitas ditampilkan`);
}


/**
 *  * FUNGSI: MUAT DAN TAMPILKAN JENIS TRANSPORTASI
 *  * Fungsi ini menampilkan card untuk setiap jenis transportasi (Pesawat, Kapal, Bus)
 * dengan gambar yang berbeda untuk mode terang dan gelap
 */
function muatDanTampilkanJenisTransportasi() {
    // Cari kontainer untuk menampilkan jenis transportasi
    const kontainerJenisTransportasi = document.getElementById('transport-grid');

    // Jika kontainer tidak ditemukan, hentikan fungsi
    if (!kontainerJenisTransportasi) {
        console.warn('⚠️ Kontainer jenis transportasi tidak ditemukan');
        return;
    }

    // Kosongkan kontainer terlebih dahulu
    kontainerJenisTransportasi.innerHTML = '';

    // Gunakan data dari transportTypesData, jika kosong gunakan data default
    const jenisTransportasi = (transportTypesData && transportTypesData.length > 0)
        ? transportTypesData
        : [
            { key: 'pesawat', name: 'Pesawat', icon: 'icon icon-plane', imageLight: './JenisTransportasi/pesawatterang.png', imageDark: './JenisTransportasi/pesawatgelap.png' },
            { key: 'kapal', name: 'Kapal', icon: 'icon icon-ship', imageLight: './JenisTransportasi/kapalterang.png', imageDark: './JenisTransportasi/kapalgelap.png' },
            { key: 'bus', name: 'Bus', icon: 'icon icon-bus', imageLight: './JenisTransportasi/busterang.png', imageDark: './JenisTransportasi/busgelap.png' }
        ];

    // Loop melalui setiap jenis transportasi
    jenisTransportasi.forEach(jenis => {
        // Ambil layanan untuk jenis transportasi ini
        const layanan = dataTransportasi[jenis.key] || [];

        // Cek apakah website menggunakan mode gelap
        const apakahModeGelap = document.body.getAttribute('data-theme') === 'dark';

        // Tentukan gambar yang akan digunakan berdasarkan mode
        let gambarYangDigunakan = apakahModeGelap
            ? (jenis.imageDark || jenis.imageLight)
            : (jenis.imageLight || jenis.imageDark);

        // Fallback untuk path gambar yang benar
        if (jenis.key === 'pesawat') {
            gambarYangDigunakan = apakahModeGelap
                ? 'JenisTransportasi/pesawatgelap.png'
                : 'JenisTransportasi/pesawatterang.png';
        } else if (jenis.key === 'kapal') {
            gambarYangDigunakan = apakahModeGelap
                ? 'JenisTransportasi/kapalgelap.png'
                : 'JenisTransportasi/kapalterang.png';
        } else if (jenis.key === 'bus') {
            gambarYangDigunakan = apakahModeGelap
                ? 'JenisTransportasi/busgelap.png'
                : 'JenisTransportasi/busterang.png';
        }

        // Buat elemen card untuk jenis transportasi
        const kartuTransportasi = document.createElement('div');
        kartuTransportasi.className = 'transport-card';
        kartuTransportasi.innerHTML = `
            <div class="transport-image">
                <img src="${gambarYangDigunakan}" alt="${jenis.name}" class="transport-type-image" 
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="transport-icon-fallback" style="display: none;">
                    <i class="${jenis.icon}"></i>
                </div>
            </div>
            <div class="transport-card-content">
                <h3>${jenis.name}</h3>
                <p>${layanan.length} layanan tersedia</p>
                <button class="btn-transport" onclick="tanganiKlikJenisTransportasi('${jenis.key}')">Lihat Layanan</button>
            </div>
        `;

        // Tambahkan card ke kontainer
        kontainerJenisTransportasi.appendChild(kartuTransportasi);
    });

    console.log(`${jenisTransportasi.length} jenis transportasi ditampilkan`);
}

/**
 *  * FUNGSI: MUAT TAB FILTER TRANSPORTASI
 *  * Fungsi ini membuat tab-tab untuk filter layanan berdasarkan jenis transportasi
 * Tab "Semua Layanan" akan menampilkan semua layanan
 */
function muatTabFilterTransportasi() {
    const kontainerTab = document.getElementById('transport-filter-tabs');

    if (!kontainerTab) {
        console.warn('⚠️ Kontainer tab tidak ditemukan');
        return;
    }

    // Kosongkan kontainer tab
    kontainerTab.innerHTML = '';

    // Buat tab "Semua Layanan"
    const tabSemuaLayanan = document.createElement('button');
    tabSemuaLayanan.className = 'transport-tab active';
    tabSemuaLayanan.onclick = () => {
        muatDanTampilkanSemuaLayanan();
        setelTabAktif(tabSemuaLayanan);
    };

    // Hitung total layanan dari semua jenis transportasi
    const totalLayanan = Object.values(dataTransportasi).reduce((total, layanan) => total + layanan.length, 0);
    tabSemuaLayanan.innerHTML = `
        <i class="icon icon-star transport-tab-icon"></i>
        <span class="transport-tab-text">Semua Layanan</span>
        <span class="transport-tab-count">${totalLayanan}</span>
    `;
    kontainerTab.appendChild(tabSemuaLayanan);

    // Data jenis transportasi
    const jenisTransportasi = (transportTypesData && transportTypesData.length > 0) ? transportTypesData : [
        { key: 'pesawat', name: 'Pesawat', icon: 'icon icon-plane', imageLight: './JenisTransportasi/pesawatterang.png', imageDark: './JenisTransportasi/pesawatgelap.png' },
        { key: 'kapal', name: 'Kapal', icon: 'icon icon-ship', imageLight: './JenisTransportasi/kapalterang.png', imageDark: './JenisTransportasi/kapalgelap.png' },
        { key: 'bus', name: 'Bus', icon: 'icon icon-bus', imageLight: './JenisTransportasi/busterang.png', imageDark: './JenisTransportasi/busgelap.png' }
    ];

    // Loop melalui setiap jenis transportasi dan buat tab-nya
    jenisTransportasi.forEach(jenis => {
        const layanan = dataTransportasi[jenis.key] || [];

        // Skip jika tidak ada layanan
        if (layanan.length === 0) return;

        // Pilih gambar berdasarkan tema (gelap/terang)
        const apakahModeGelap = document.body.getAttribute('data-theme') === 'dark';
        const gambarYangDigunakan = apakahModeGelap
            ? (jenis.imageDark || jenis.imageLight)
            : (jenis.imageLight || jenis.imageDark);

        // Buat tab untuk jenis transportasi
        const tabJenisTransportasi = document.createElement('button');
        tabJenisTransportasi.className = 'transport-tab';
        tabJenisTransportasi.onclick = () => {
            filterKontenBerdasarkanJenisTransportasi(jenis.key);
            setelTabAktif(tabJenisTransportasi);
        };

        tabJenisTransportasi.innerHTML = `
            <img src="${gambarYangDigunakan}" alt="${jenis.name}" class="transport-tab-image" 
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
            <i class="${jenis.icon} transport-tab-icon" style="display: none;"></i>
            <span class="transport-tab-text">${jenis.name}</span>
            <span class="transport-tab-count">${layanan.length}</span>
        `;
        kontainerTab.appendChild(tabJenisTransportasi);
    });

    console.log('✅ Tab filter transportasi berhasil dimuat');
}

/**
 *  * FUNGSI: SETEL TAB AKTIF
 *  * Fungsi ini mengatur tab mana yang aktif (terpilih)
 * @param {HTMLElement} tabAktif - Elemen tab yang akan diaktifkan
 */
function setelTabAktif(tabAktif) {
    // Hapus class 'active' dari semua tab
    const semuaTab = document.querySelectorAll('.transport-tab');
    semuaTab.forEach(tab => tab.classList.remove('active'));

    // Tambahkan class 'active' ke tab yang diklik
    tabAktif.classList.add('active');
}

/**
 *  * FUNGSI: MUAT DAN TAMPILKAN SEMUA LAYANAN
 *  * Fungsi ini menampilkan semua layanan dari semua jenis transportasi
 * Digunakan ketika user mengklik tab "Semua Layanan"
 */
function muatDanTampilkanSemuaLayanan() {
    console.log('✈️ Memuat semua layanan...');
    const kontainerLayanan = document.getElementById('transport-cards-grid');

    if (!kontainerLayanan) {
        console.warn('⚠️ Kontainer layanan tidak ditemukan');
        return;
    }

    // Kosongkan kontainer
    kontainerLayanan.innerHTML = '';

    // Buat grid container
    const kontainerGrid = document.createElement('div');
    kontainerGrid.className = 'services-grid';
    kontainerLayanan.appendChild(kontainerGrid);

    // Loop melalui setiap jenis transportasi
    for (const [jenisTransportasi, layanan] of Object.entries(dataTransportasi)) {
        // Skip jika tidak ada layanan
        if (layanan.length === 0) continue;

        // Loop melalui setiap layanan
        for (const layananItem of layanan) {
            // Buat card untuk layanan
            const kartuLayanan = document.createElement('div');
            kartuLayanan.className = 'partner-card';
            kartuLayanan.innerHTML = `
                <div class="airline-logo-img">
                    <img src="${layananItem.logo}" alt="${layananItem.name}" onerror="this.style.display='none'">
                </div>
                <div class="partner-info">
                    <h4>${layananItem.name}</h4>
                    <p><i class="icon icon-route"></i> ${layananItem.route}</p>
                    <p><i class="icon icon-money"></i> ${layananItem.price}</p>
                    <button class="btn-wa-small" onclick="pesanViaWhatsApp('${layananItem.name} - ${layananItem.route}')">
                        Pesan Sekarang
                    </button>
                </div>
            `;
            kontainerGrid.appendChild(kartuLayanan);
        }
    }
    console.log('✅ Semua layanan berhasil dimuat');
}

/**
 *  * FUNGSI: FILTER KONTEN BERDASARKAN JENIS TRANSPORTASI
 *  * Fungsi ini menampilkan hanya layanan dari jenis transportasi tertentu
 * @param {string} jenisTransportasi - Key jenis transportasi (pesawat, kapal, bus)
 */
function filterKontenBerdasarkanJenisTransportasi(jenisTransportasi) {
    console.log('🔍 Memfilter konten untuk:', jenisTransportasi);

    // Ambil layanan untuk jenis transportasi ini
    const layanan = dataTransportasi[jenisTransportasi] || [];
    const kontainerLayanan = document.getElementById('transport-cards-grid');

    // Cek apakah kontainer ditemukan
    if (!kontainerLayanan) {
        console.error('❌ Kontainer layanan tidak ditemukan');
        return;
    }

    // Jika tidak ada layanan, tampilkan pesan
    if (layanan.length === 0) {
        kontainerLayanan.innerHTML = '<p class="no-data"><i class="icon icon-exclamation"></i> Belum ada layanan tersedia untuk transportasi ini.</p>';
        return;
    }

    // Kosongkan kontainer
    kontainerLayanan.innerHTML = '';

    // Buat nama tampilan (huruf pertama besar)
    const namaTampilan = jenisTransportasi.charAt(0).toUpperCase() + jenisTransportasi.slice(1);

    // Buat header
    const elemenHeader = document.createElement('div');
    elemenHeader.className = 'services-header';
    elemenHeader.innerHTML = `<h3>Layanan ${namaTampilan}</h3>`;
    kontainerLayanan.appendChild(elemenHeader);

    // Buat grid container
    const kontainerGrid = document.createElement('div');
    kontainerGrid.className = 'services-grid';
    kontainerLayanan.appendChild(kontainerGrid);

    // Loop melalui setiap layanan dan buat card-nya
    layanan.forEach((layananItem) => {
        const kartuLayanan = document.createElement('div');
        kartuLayanan.className = 'partner-card';
        kartuLayanan.innerHTML = `
            <div class="airline-logo-img">
                <img src="${layananItem.logo}" alt="${layananItem.name}" onerror="this.style.display='none'">
            </div>
            <div class="partner-info">
                <h4>${layananItem.name}</h4>
                <p><i class="icon icon-route"></i> ${layananItem.route}</p>
                <p><i class="icon icon-money"></i> ${layananItem.price}</p>
                <button class="btn-wa-small" onclick="pesanViaWhatsApp('${layananItem.name} - ${layananItem.route}')">
                    Pesan Sekarang
                </button>
            </div>
        `;
        kontainerGrid.appendChild(kartuLayanan);
    });

    // Scroll halus ke bagian layanan setelah 200ms
    setTimeout(() => {
        gulungKeBagian('services');
    }, 200);
}

/**
 *  * FUNGSI: TANGANI KLIK JENIS TRANSPORTASI
 *  * Fungsi ini dipanggil ketika user mengklik card jenis transportasi
 * @param {string} jenisTransportasi - Key jenis transportasi (pesawat, kapal, bus)
 */
function tanganiKlikJenisTransportasi(jenisTransportasi) {
    console.log('🖱️ Jenis transportasi diklik:', jenisTransportasi);
    filterKontenBerdasarkanJenisTransportasi(jenisTransportasi);
}

/**
 *  * FUNGSI: GULUNG KE BAGIAN TERTENTU
 *  * Fungsi ini melakukan scroll halus ke bagian tertentu di halaman
 * @param {string} idBagian - ID dari elemen yang ingin dituju
 */
function gulungKeBagian(idBagian) {
    const bagian = document.getElementById(idBagian);

    if (bagian) {
        // Tinggi header untuk offset
        const tinggiHeader = 80;
        const posisiTarget = bagian.offsetTop - tinggiHeader;

        // Lakukan scroll halus
        gulungHalusKePosisi(posisiTarget, 1200);

        // Tutup menu mobile jika terbuka
        const menuNavigasi = document.querySelector('.nav-menu');
        if (menuNavigasi && menuNavigasi.classList.contains('active')) {
            menuNavigasi.classList.remove('active');
        }

        console.log(`🎯 Scroll halus ke bagian: ${idBagian}`);
    } else {
        console.warn(`⚠️ Bagian dengan ID "${idBagian}" tidak ditemukan`);
    }
}

/**
 *  * SCROLL YANG LEBIH SEDERHANA
 *  */
function gulungHalusKePosisi(posisiTarget, durasi = 800) {
    window.scrollTo({
        top: posisiTarget,
        behavior: 'smooth'
    });
}

// Alias untuk kompatibilitas
window.smoothScrollTo = gulungHalusKePosisi;


// konfigurasi admin panel
const ADMIN_CONFIG = {
    password: 'cendana123'
};

function showAdminLogin() {
    const overlay = document.getElementById('adminLoginOverlay');
    if (overlay) {
        overlay.style.display = 'flex';
        setTimeout(() => {
            const passwordInput = document.getElementById('adminPassword');
            if (passwordInput) {
                passwordInput.focus();
            }
        }, 100);
    }
}

function closeAdminLogin() {
    const overlay = document.getElementById('adminLoginOverlay');
    if (overlay) {
        overlay.style.display = 'none';
        const passwordInput = document.getElementById('adminPassword');
        if (passwordInput) {
            passwordInput.value = '';
            passwordInput.type = 'password';
        }
        // Reset icon ke mata
        const icon = document.getElementById('passwordToggleIcon');
        if (icon) {
            icon.className = 'icon icon-eye';
        }
    }
}

/**
 * Toggle show/hide password
 * Ganti ikon mata jadi mata coret pas password keliatan
 */
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('adminPassword');
    const icon = document.getElementById('passwordToggleIcon');

    if (!passwordInput || !icon) return;

    if (passwordInput.type === 'password') {
        // Tampilkan password
        passwordInput.type = 'text';
        icon.className = 'icon icon-eye-slash';
    } else {
        // Sembunyikan password
        passwordInput.type = 'password';
        icon.className = 'icon icon-eye';
    }
}

function attemptAdminLogin() {
    const passwordInput = document.getElementById('adminPassword');
    const loginButton = document.querySelector('.btn-admin-login');

    if (!passwordInput || !loginButton) return;

    const password = passwordInput.value.trim();

    if (!password) {
        alert('Masukkan password terlebih dahulu.');
        passwordInput.focus();
        return;
    }

    loginButton.disabled = true;
    loginButton.innerHTML = '<i class="icon icon-spinner"></i> Memverifikasi...';

    // Kirim request login ke server menggunakan AJAX
    fetch('auth.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=login&password=' + encodeURIComponent(password)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loginSuccess(data.redirect);
            } else {
                loginFailed(data.message);
            }

            loginButton.disabled = false;
            loginButton.innerHTML = '<i class="icon icon-sign-in"></i> Login';
        })
        .catch(error => {
            console.error('Login error:', error);
            alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
            loginButton.disabled = false;
            loginButton.innerHTML = '<i class="icon icon-sign-in"></i> Login';
        });
}

function loginSuccess(redirectUrl) {
    closeAdminLogin();

    setTimeout(() => {
        alert('Login berhasil! Mengarahkan ke dashboard admin...');
        window.location.href = redirectUrl || 'admin.php';
    }, 500);
}

function loginFailed(message) {
    alert(message || 'Password salah. Silakan coba lagi.');

    const passwordInput = document.getElementById('adminPassword');
    if (passwordInput) {
        passwordInput.value = '';
        passwordInput.focus();
    }
}


/**
 *  * INISIALISASI SAAT HALAMAN DIMUAT
 *  * Kode ini akan dijalankan setelah halaman selesai dimuat
 */
document.addEventListener('DOMContentLoaded', function () {
    console.log('🚀 Memulai inisialisasi website...');

    // muat data dari localStorage
    muatDataDariPenyimpanan();

    // form whatsapp booking sudah dihapus

    // Set minimum date untuk input date (hari ini)
    const today = new Date().toISOString().split('T')[0];
    const departureDateInput = document.getElementById('departure-date');
    const returnDateInput = document.getElementById('return-date');

    if (departureDateInput) {
        departureDateInput.setAttribute('min', today);
        departureDateInput.addEventListener('change', function () {
            // Set minimum return date sama dengan departure date
            if (returnDateInput && this.value) {
                returnDateInput.setAttribute('min', this.value);
            }
        });
    }

    if (returnDateInput) {
        returnDateInput.setAttribute('min', today);
    }

    // Keyboard shortcut untuk admin login (Ctrl+Shift+A)
    document.addEventListener('keydown', function (event) {
        if (event.ctrlKey && event.shiftKey && event.key === 'A') {
            event.preventDefault();
            showAdminLogin();
        }
    });

    // Enter key untuk login admin
    const passwordInput = document.getElementById('adminPassword');
    if (passwordInput) {
        passwordInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                attemptAdminLogin();
            }
        });
    }

    const sections = document.querySelectorAll('#transport-types, #services, #destinations');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.dataset.loaded) {
                const sectionId = entry.target.id;
                console.log(`📍 Loading ${sectionId}...`);

                switch (sectionId) {
                    case 'transport-types':
                        muatDanTampilkanJenisTransportasi();
                        break;
                    case 'services':
                        muatDanTampilkanSemuaLayanan();
                        break;
                    case 'destinations':
                        muatDanTampilkanFasilitas();
                        break;
                }

                entry.target.dataset.loaded = 'true';
            }
        });
    }, {
        root: null,
        rootMargin: '100px',
        threshold: 0.1
    });

    sections.forEach(section => {
        if (section) {
            observer.observe(section);
        }
    });

    // Muat semua konten setelah 500ms (memberi waktu untuk DOM siap)
    setTimeout(() => {
        console.log('🚀 Memuat semua konten...');
        muatDanTampilkanJenisTransportasi();
        muatTabFilterTransportasi(); // Muat tab filter transportasi
        muatDanTampilkanSemuaLayanan();
        muatDanTampilkanFasilitas();
        muatInformasiPerusahaan(); // Muat informasi perusahaan untuk halaman utama
        console.log('✅ Semua konten berhasil dimuat');
    }, 500);

    // Mobile menu toggle
    const mobileMenu = document.querySelector('.mobile-menu');
    const navMenu = document.querySelector('.nav-menu');

    if (mobileMenu && navMenu) {
        mobileMenu.addEventListener('click', function () {
            navMenu.classList.toggle('active');
        });
    }

    // Enhanced smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');

            if (targetId === '#' || targetId === '#home') {
                // Scroll halus ke atas
                gulungHalusKePosisi(0, 1000);
                return;
            }

            const sectionId = targetId.replace('#', '');
            gulungKeBagian(sectionId);
        });
    });

    // Cek apakah ini halaman admin
    if (document.body.classList.contains('admin-body') || window.location.pathname.includes('admin.php')) {
        console.log('🔧 Menginisialisasi halaman admin...');

        muatDataDariPenyimpanan();

        const semuaForm = document.querySelectorAll('.admin-form');
        semuaForm.forEach(form => {
            form.style.display = 'none';
        });

        setTimeout(() => {
            showSection('destinations');
        }, 200);

        const itemMenuDestinations = document.querySelector('[onclick="showSection(\'destinations\')"]');
        if (itemMenuDestinations) {
            itemMenuDestinations.closest('li').classList.add('active');
        }

        console.log('✅ Halaman admin diinisialisasi');
        console.log('📊 Status data:', {
            fasilitas: dataFasilitas.length,
            jenisTransportasi: Object.keys(dataTransportasi).length,
            dataJenisTransportasi: transportTypesData.length
        });
    }

    console.log('✅ Cv. Cendana Travel Script Berhasil Diinisialisasi!');
    console.log('💡 Jika alamat masih lama, jalankan: forceRefreshCompanyData() di console');
});


function getTransportFolderPath(transportType) {
    const folderMap = {
        'pesawat': 'pesawat',
        'kapal': 'kapal',
        'bus': 'bus'
    };
    return folderMap[transportType] || 'uploads';
}

function showSection(sectionName) {
    try {
        console.log(`🔄 Switching to section: ${sectionName}`);

        const sections = document.querySelectorAll('.admin-section');
        sections.forEach(section => {
            section.style.display = 'none';
        });

        const targetSection = document.getElementById(sectionName + '-section');
        console.log(`🔍 Looking for section: ${sectionName}-section`);
        console.log(`🔍 Found section:`, targetSection);

        const allSections = document.querySelectorAll('.admin-section');
        console.log('🔍 All available sections:', Array.from(allSections).map(s => s.id));

        if (targetSection) {
            targetSection.style.display = 'block';
            console.log(`✅ Section ${sectionName} displayed`);
            console.log(`✅ Section display style:`, targetSection.style.display);
        } else {
            console.error(`❌ Section ${sectionName}-section not found`);
        }

        // Update actif menu
        const menuItems = document.querySelectorAll('.sidebar-menu li');
        menuItems.forEach(item => item.classList.remove('active'));

        const activeMenuItem = document.querySelector(`[onclick="showSection('${sectionName}')"]`);
        if (activeMenuItem) {
            activeMenuItem.closest('li').classList.add('active');
            console.log(`✅ Menu item ${sectionName} activated`);
        }

        // data
        switch (sectionName) {
            case 'destinations':
                if (typeof loadFacilitiesAdmin === 'function') {
                    loadFacilitiesAdmin();
                } else {
                    console.error('❌ loadFacilitiesAdmin function not found');
                }
                break;
            case 'tickets':
                if (typeof loadTicketsAdmin === 'function') {
                    loadTicketsAdmin();
                }
                if (typeof populateTransportTypeSelect === 'function') {
                    populateTransportTypeSelect();
                }
                break;
            case 'transport-types':
                if (typeof loadTransportTypesAdmin === 'function') {
                    loadTransportTypesAdmin();
                }
                // Update halaman utama juga
                if (typeof muatDanTampilkanJenisTransportasi === 'function') {
                    muatDanTampilkanJenisTransportasi();
                }
                break;
            case 'company-info':
                console.log('🏢 COMPANY-INFO CASE TRIGGERED');
                const companySection = document.getElementById('company-info-section');
                console.log('🏢 Company section element:', companySection);
                if (companySection) {
                    console.log('🏢 Company section innerHTML length:', companySection.innerHTML.length);
                    console.log('🏢 Company section display before:', companySection.style.display);

                    // FORCE VISIBILITY
                    companySection.style.display = 'block';
                    companySection.style.visibility = 'visible';
                    companySection.style.opacity = '1';
                    companySection.style.height = 'auto';
                    companySection.style.overflow = 'visible';

                    console.log('🏢 Company section display after:', companySection.style.display);
                    console.log('🏢 Company section visibility:', companySection.style.visibility);
                }
                if (typeof loadCompanyInfoAdmin === 'function') {
                    setTimeout(() => {
                        loadCompanyInfoAdmin();
                    }, 100);
                }
                break;
            default:
                console.log(`ℹ️ No specific loader for section: ${sectionName}`);
        }
    } catch (error) {
        console.error(`❌ Error in showSection(${sectionName}):`, error);
    }
}

// Load Facilities Admin
function loadFacilitiesAdmin() {
    console.log('📋 Loading facilities admin...');
    const container = document.getElementById('facilities-list');
    if (!container) {
        console.error('❌ facilities-list container not found');
        return;
    }

    // Create professional table
    container.innerHTML = `
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Fasilitas</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="facilities-table-body">
            </tbody>
        </table>
    `;

    const tableBody = document.getElementById('facilities-table-body');

    console.log('🔍 Facilities data:', dataFasilitas);

    dataFasilitas.forEach((facility, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><strong>${index + 1}</strong></td>
            <td>
                <img src="${facility.image}" alt="${facility.name}" class="table-image" 
                     onerror="this.src='https://via.placeholder.com/60x40/3498db/ffffff?text=IMG'">
            </td>
            <td>
                <div class="table-title">${facility.name}</div>
            </td>
            <td>
                <div class="table-description">${facility.description}</div>
            </td>
            <td>
                <div class="table-actions">
                    <button class="btn-edit" data-index="${index}" title="Edit ${facility.name}">
                        <i class="icon icon-edit"></i>
                    </button>
                    <button class="btn-delete" data-index="${index}" title="Hapus ${facility.name}">
                        <i class="icon icon-trash"></i>
                    </button>
                </div>
            </td>
        `;
        tableBody.appendChild(row);

        // Add event listeners directly
        const editBtn = row.querySelector('.btn-edit');
        const deleteBtn = row.querySelector('.btn-delete');

        if (editBtn) {
            editBtn.addEventListener('click', () => {
                console.log('Edit button clicked for index:', index);
                editFacility(index);
            });
        }

        if (deleteBtn) {
            deleteBtn.addEventListener('click', () => {
                console.log('Delete button clicked for index:', index);
                deleteFacility(index);
            });
        }
    });

    console.log(`✅ Loaded ${dataFasilitas.length} facilities in table format`);
}

// Show Add Facility Form
function showAddFacilityForm() {
    const form = document.getElementById('add-facility-form');
    if (form) {
        form.style.display = 'block';

        // Reset form
        document.getElementById('facility-name').value = '';
        document.getElementById('facility-description').value = '';
        document.getElementById('facility-image').value = '';

        // Hide preview
        const preview = document.getElementById('facility-preview');
        if (preview) {
            preview.style.display = 'none';
        }

        // Reset form title and button
        const formTitle = document.querySelector('#add-facility-form h3');
        if (formTitle) {
            formTitle.textContent = 'Tambah Fasilitas Baru';
        }

        const saveButton = document.querySelector('#add-facility-form .btn-primary');
        if (saveButton) {
            saveButton.textContent = 'Simpan';
            saveButton.onclick = addFacility;
        }
    }
}

// Hide Add Facility Form
function hideAddFacilityForm() {
    const form = document.getElementById('add-facility-form');
    if (form) {
        form.style.display = 'none';
    }
}

// Add Facility
async function addFacility() {
    const name = document.getElementById('facility-name').value.trim();
    const description = document.getElementById('facility-description').value.trim();
    const imageFile = document.getElementById('facility-image').files[0];

    if (!name || !description) {
        alert('Mohon lengkapi nama dan deskripsi fasilitas!');
        return;
    }

    let imagePath;

    if (imageFile) {
        try {
            // Generate filename for cendana folder
            const timestamp = Date.now();
            const extension = imageFile.name.split('.').pop().toLowerCase();
            const filename = `facility_${timestamp}.${extension}`;

            // Try to upload to server
            const formData = new FormData();
            formData.append('facilityImage', imageFile);
            formData.append('type', 'facility');
            formData.append('filename', filename);

            const response = await fetch('upload.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                imagePath = result.data.file_path;
                console.log(`✅ Image uploaded successfully: ${imagePath}`);
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.log('⚠️ Server upload failed, using local preview:', error.message);
            // Fallback to object URL for demo
            imagePath = URL.createObjectURL(imageFile);
            const timestamp = Date.now();
            const extension = imageFile.name.split('.').pop().toLowerCase();
            console.log(`📁 Image would be saved as: cendana/facility_${timestamp}.${extension}`);
        }
    } else {
        // Use placeholder
        imagePath = `https://via.placeholder.com/400x300/3498db/ffffff?text=${encodeURIComponent(name)}`;
    }

    const newFacility = {
        id: Date.now(),
        name: name,
        description: description,
        image: imagePath
    };

    // Add to data
    dataFasilitas.push(newFacility);

    // Simpan ke localStorage
    simpanDataKePenyimpanan();

    // Update tampilan
    loadFacilitiesAdmin();
    muatDanTampilkanFasilitas(); // Update halaman utama
    hideAddFacilityForm();

    alert(`✅ Fasilitas "${name}" berhasil ditambahkan!`);
}

// Edit Facility
function editFacility(index) {
    console.log('🔧 editFacility called with index:', index);

    if (!dataFasilitas || dataFasilitas.length === 0) {
        alert('❌ Data fasilitas tidak tersedia');
        return;
    }

    if (index < 0 || index >= dataFasilitas.length) {
        alert('❌ Index fasilitas tidak valid: ' + index);
        return;
    }

    const facility = dataFasilitas[index];
    console.log('✏️ Editing facility:', facility);

    // Show the form
    showAddFacilityForm();

    // Populate form with existing data
    document.getElementById('facility-name').value = facility.name;
    document.getElementById('facility-description').value = facility.description;

    if (facility.image) {
        const preview = document.getElementById('facility-preview');
        const img = document.getElementById('facility-preview-img');
        if (preview && img) {
            img.src = facility.image;
            preview.style.display = 'block';
        }
    }

    // Change form title and button
    const formTitle = document.querySelector('#add-facility-form h3');
    if (formTitle) {
        formTitle.textContent = `Edit Fasilitas: ${facility.name}`;
    }

    const saveButton = document.querySelector('#add-facility-form .btn-primary');
    if (saveButton) {
        saveButton.textContent = 'Update';
        saveButton.onclick = () => updateFacility(index);
    }
}

// Update Facility
async function updateFacility(index) {
    const name = document.getElementById('facility-name').value.trim();
    const description = document.getElementById('facility-description').value.trim();
    const imageFile = document.getElementById('facility-image').files[0];

    if (!name || !description) {
        alert('Mohon lengkapi nama dan deskripsi fasilitas!');
        return;
    }

    // Update the facility data
    const facility = dataFasilitas[index];
    facility.name = name;
    facility.description = description;

    // Update image if new file uploaded
    if (imageFile) {
        try {
            const timestamp = Date.now();
            const extension = imageFile.name.split('.').pop().toLowerCase();
            const filename = `facility_${timestamp}.${extension}`;

            // Try to upload to server
            const formData = new FormData();
            formData.append('facilityImage', imageFile);
            formData.append('type', 'facility');
            formData.append('filename', filename);

            const response = await fetch('upload.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                facility.image = result.data.file_path;
                console.log(`✅ Image updated successfully: ${facility.image}`);
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.log('⚠️ Server upload failed, using local preview:', error.message);
            // Fallback to object URL for demo
            facility.image = URL.createObjectURL(imageFile);
            const timestamp = Date.now();
            const extension = imageFile.name.split('.').pop().toLowerCase();
            console.log(`📁 Image would be updated as: cendana/facility_${timestamp}.${extension}`);
        }
    }

    // Simpan ke localStorage
    simpanDataKePenyimpanan();

    // Update tampilan
    loadFacilitiesAdmin();
    muatDanTampilkanFasilitas(); // Update halaman utama
    hideAddFacilityForm();

    alert(`✅ Fasilitas "${name}" berhasil diperbarui!`);
}

// Delete Facility
function deleteFacility(index) {
    const facility = dataFasilitas[index];
    if (confirm(`Apakah Anda yakin ingin menghapus fasilitas "${facility.name}"?`)) {
        // Hapus dari data
        dataFasilitas.splice(index, 1);

        // Simpan ke localStorage
        simpanDataKePenyimpanan();

        // Update tampilan
        loadFacilitiesAdmin();
        muatDanTampilkanFasilitas(); // Update halaman utama

        alert(`✅ Fasilitas "${facility.name}" berhasil dihapus!`);
    }
}

// Preview Facility Image
function previewFacilityImage(input) {
    const preview = document.getElementById('facility-preview');
    const img = document.getElementById('facility-preview-img');

    if (!preview || !img) {
        console.error('Preview elements not found');
        return;
    }

    if (input.files && input.files[0]) {
        const file = input.files[0];

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
            input.value = '';
            return;
        }

        // Validate file size (max 5MB)
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            const fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
            alert(`Ukuran file terlalu besar (${fileSizeMB}MB). Maksimal 5MB.`);
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
            preview.style.display = 'block';
            console.log('✅ Image preview loaded');
        };

        reader.onerror = function () {
            alert('Gagal membaca file. Coba lagi.');
            input.value = '';
        };

        reader.readAsDataURL(file);
    }
}

// Remove Facility Image Preview
function removeFacilityImagePreview() {
    const preview = document.getElementById('facility-preview');
    const input = document.getElementById('facility-image');

    if (preview) {
        preview.style.display = 'none';
    }

    if (input) {
        input.value = '';
    }
}

// ===== TRANSPORT TYPES ADMIN FUNCTIONS // Load Transport Types Admin
function loadTransportTypesAdmin() {
    console.log('🚌 Loading transport types admin...');
    const container = document.getElementById('transport-types-list');
    if (!container) {
        console.error('❌ transport-types-list container not found');
        return;
    }

    // Create professional table
    container.innerHTML = `
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Logo Terang</th>
                    <th>Logo Gelap</th>
                    <th>Nama Transportasi</th>
                    <th>Deskripsi</th>
                    <th>Layanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="transport-types-table-body">
            </tbody>
        </table>
    `;

    const tableBody = document.getElementById('transport-types-table-body');

    transportTypesData.forEach((type, index) => {
        const serviceCount = dataTransportasi[type.key] ? dataTransportasi[type.key].length : 0;

        // Show current images - PERBAIKAN: Langsung set path yang benar
        let currentImageLight = 'JenisTransportasi/placeholder.png';
        let currentImageDark = 'JenisTransportasi/placeholder.png';

        if (type.key === 'pesawat') {
            currentImageLight = 'JenisTransportasi/pesawatterang.png';
            currentImageDark = 'JenisTransportasi/pesawatgelap.png';
        } else if (type.key === 'kapal') {
            currentImageLight = 'JenisTransportasi/kapalterang.png';
            currentImageDark = 'JenisTransportasi/kapalgelap.png';
        } else if (type.key === 'bus') {
            currentImageLight = 'JenisTransportasi/busterang.png';
            currentImageDark = 'JenisTransportasi/busgelap.png';
        }

        const row = document.createElement('tr');
        row.innerHTML = `
            <td><strong>${index + 1}</strong></td>
            <td>
                <img src="${currentImageLight}" alt="${type.name} Light" class="table-image" 
                     onload="console.log('✅ Admin light image loaded:', '${currentImageLight}')"
                     onerror="console.log('❌ Admin light image failed:', '${currentImageLight}'); this.src='https://via.placeholder.com/60x40/f8f9fa/333?text=Light'">
            </td>
            <td>
                <img src="${currentImageDark}" alt="${type.name} Dark" class="table-image" 
                     onload="console.log('✅ Admin dark image loaded:', '${currentImageDark}')"
                     onerror="console.log('❌ Admin dark image failed:', '${currentImageDark}'); this.src='https://via.placeholder.com/60x40/333/fff?text=Dark'">
            </td>
            <td>
                <div class="table-title">${type.name}</div>
            </td>
            <td>
                <div class="table-description">${type.description}</div>
            </td>
            <td>
                <span class="table-badge">${serviceCount} layanan</span>
            </td>
            <td>
                <div class="table-actions">
                    <button class="btn-edit" title="Edit ${type.name}">
                        <i class="icon icon-edit"></i>
                    </button>
                </div>
            </td>
        `;
        tableBody.appendChild(row);

        // Add event listener directly
        const editBtn = row.querySelector('.btn-edit');
        if (editBtn) {
            editBtn.addEventListener('click', () => {
                console.log('Edit transport type clicked:', index);
                editTransportType(index);
            });
        }
    });

    console.log(`✅ Loaded ${transportTypesData.length} transport types in table format`);
}

// Show Add Transport Type Form
function showAddTransportTypeForm() {
    const form = document.getElementById('add-transport-type-form');
    if (form) {
        form.style.display = 'block';

        // Reset form
        document.getElementById('transport-type-key').value = '';
        document.getElementById('transport-type-name').value = '';
        document.getElementById('transport-type-description').value = '';
        document.getElementById('transport-type-light-image').value = '';
        document.getElementById('transport-type-dark-image').value = '';

        // Hide previews
        const lightPreview = document.getElementById('transport-light-preview');
        const darkPreview = document.getElementById('transport-dark-preview');
        if (lightPreview) lightPreview.style.display = 'none';
        if (darkPreview) darkPreview.style.display = 'none';
    }
}

// Hide Add Transport Type Form
function hideAddTransportTypeForm() {
    const form = document.getElementById('add-transport-type-form');
    if (form) {
        form.style.display = 'none';
    }
}

// Add Transport Type
async function addTransportType() {
    const key = document.getElementById('transport-type-key').value.trim();
    const name = document.getElementById('transport-type-name').value.trim();
    const description = document.getElementById('transport-type-description').value.trim();
    const lightImageFile = document.getElementById('transport-type-light-image').files[0];
    const darkImageFile = document.getElementById('transport-type-dark-image').files[0];

    if (!key || !name || !description) {
        alert('Mohon lengkapi semua field yang diperlukan!');
        return;
    }

    // Check if key already exists
    if (transportTypesData.find(t => t.key === key)) {
        alert('Kode transportasi sudah ada! Gunakan kode yang berbeda.');
        return;
    }

    let lightImagePath = `JenisTransportasi/${key}terang.png`;
    let darkImagePath = `JenisTransportasi/${key}gelap.png`;

    // Handle light image upload
    if (lightImageFile) {
        try {
            const extension = lightImageFile.name.split('.').pop().toLowerCase();
            const filename = `${key}terang.${extension}`;

            // Upload to server
            const formData = new FormData();
            formData.append('logoFile', lightImageFile);
            formData.append('type', 'transport');
            formData.append('filename', filename);

            const response = await fetch('upload.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                lightImagePath = `JenisTransportasi/${filename}`;
                console.log('✅ Light image uploaded successfully:', lightImagePath);
            } else {
                console.log('⚠️ Light image upload failed:', result.message);
            }
        } catch (error) {
            console.log('⚠️ Light image upload failed:', error.message);
        }
    }

    // Handle dark image upload
    if (darkImageFile) {
        try {
            const extension = darkImageFile.name.split('.').pop().toLowerCase();
            const filename = `${key}gelap.${extension}`;

            // Upload to server
            const formData = new FormData();
            formData.append('logoFile', darkImageFile);
            formData.append('type', 'transport');
            formData.append('filename', filename);

            const response = await fetch('upload.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                darkImagePath = `JenisTransportasi/${filename}`;
                console.log('✅ Dark image uploaded successfully:', darkImagePath);
            } else {
                console.log('⚠️ Dark image upload failed:', result.message);
            }
        } catch (error) {
            console.log('⚠️ Dark image upload failed:', error.message);
        }
    }

    const newTransportType = {
        key: key,
        name: name,
        icon: 'icon icon-plane', // Default icon
        imageLight: lightImagePath,
        imageDark: darkImagePath,
        description: description
    };

    // Add to data
    transportTypesData.push(newTransportType);

    // Initialize empty array for this transport type in dataTransportasi
    if (!dataTransportasi[key]) {
        dataTransportasi[key] = [];
    }

    // Simpan ke localStorage
    simpanDataKePenyimpanan();

    // Update tampilan
    loadTransportTypesAdmin();
    muatDanTampilkanJenisTransportasi(); // Update halaman utama
    muatTabFilterTransportasi(); // Update tab filter
    hideAddTransportTypeForm();

    // Clear form
    document.getElementById('transport-type-key').value = '';
    document.getElementById('transport-type-name').value = '';
    document.getElementById('transport-type-description').value = '';
    document.getElementById('transport-type-light-image').value = '';
    document.getElementById('transport-type-dark-image').value = '';

    // Hide previews
    const lightPreview = document.getElementById('transport-light-preview');
    const darkPreview = document.getElementById('transport-dark-preview');
    if (lightPreview) lightPreview.style.display = 'none';
    if (darkPreview) darkPreview.style.display = 'none';

    alert(`✅ Jenis transportasi "${name}" berhasil ditambahkan!`);
}

// Edit Transport Type
function editTransportType(index) {
    console.log('🔧 editTransportType called with index:', index);

    if (!transportTypesData || transportTypesData.length === 0) {
        alert('❌ Data jenis transportasi tidak tersedia');
        return;
    }

    if (index < 0 || index >= transportTypesData.length) {
        alert('❌ Index transport type tidak valid: ' + index);
        return;
    }

    const type = transportTypesData[index];
    console.log('✏️ Editing transport type:', type);

    // Show the form
    showAddTransportTypeForm();

    // Populate form with existing data
    document.getElementById('transport-type-key').value = type.key;
    document.getElementById('transport-type-name').value = type.name;
    document.getElementById('transport-type-description').value = type.description;

    // Show current images
    if (type.imageLight) {
        const lightPreview = document.getElementById('transport-light-preview');
        const lightImg = document.getElementById('transport-light-preview-img');
        if (lightPreview && lightImg) {
            lightImg.src = type.imageLight;
            lightPreview.style.display = 'block';
        }
    }

    if (type.imageDark) {
        const darkPreview = document.getElementById('transport-dark-preview');
        const darkImg = document.getElementById('transport-dark-preview-img');
        if (darkPreview && darkImg) {
            darkImg.src = type.imageDark;
            darkPreview.style.display = 'block';
        }
    }

    // Change form title and button
    const formTitle = document.querySelector('#add-transport-type-form h3');
    if (formTitle) {
        formTitle.textContent = `Edit Jenis Transportasi: ${type.name}`;
    }

    const saveButton = document.querySelector('#add-transport-type-form .btn-primary');
    if (saveButton) {
        saveButton.textContent = 'Update';
        saveButton.onclick = () => updateTransportType(index);
    }
}

// Update Transport Type
async function updateTransportType(index) {
    const key = document.getElementById('transport-type-key').value.trim();
    const name = document.getElementById('transport-type-name').value.trim();
    const description = document.getElementById('transport-type-description').value.trim();
    const lightImageFile = document.getElementById('transport-type-light-image').files[0];
    const darkImageFile = document.getElementById('transport-type-dark-image').files[0];

    if (!key || !name || !description) {
        alert('Mohon lengkapi semua field yang diperlukan!');
        return;
    }

    // Update the transport type data
    const type = transportTypesData[index];
    type.key = key;
    type.name = name;
    type.description = description;

    // Update light image if new file uploaded
    if (lightImageFile) {
        try {
            const timestamp = Date.now();
            const extension = lightImageFile.name.split('.').pop().toLowerCase();
            const filename = `${key}terang_${timestamp}.${extension}`;

            // Try to upload to server
            const formData = new FormData();
            formData.append('transportImage', lightImageFile);
            formData.append('type', 'transport_type');
            formData.append('filename', filename);

            const response = await fetch('upload.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                type.imageLight = result.data.file_path;
                console.log(`✅ Light image updated: ${type.imageLight}`);
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.log('⚠️ Server upload failed, using local preview:', error.message);
            type.imageLight = URL.createObjectURL(lightImageFile);
        }
    }

    // Update dark image if new file uploaded
    if (darkImageFile) {
        try {
            const timestamp = Date.now();
            const extension = darkImageFile.name.split('.').pop().toLowerCase();
            const filename = `${key}gelap_${timestamp}.${extension}`;

            // Try to upload to server
            const formData = new FormData();
            formData.append('transportImage', darkImageFile);
            formData.append('type', 'transport_type');
            formData.append('filename', filename);

            const response = await fetch('upload.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                type.imageDark = result.data.file_path;
                console.log(`✅ Dark image updated: ${type.imageDark}`);
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.log('⚠️ Server upload failed, using local preview:', error.message);
            type.imageDark = URL.createObjectURL(darkImageFile);
        }
    }

    simpanDataKePenyimpanan();

    // Update tampilan
    loadTransportTypesAdmin();
    muatDanTampilkanJenisTransportasi();
    hideAddTransportTypeForm();

    alert(`✅ Jenis transportasi "${name}" berhasil diperbarui!`);
}

// Preview Transport Type Images
function previewTransportLightImage(input) {
    const preview = document.getElementById('transport-light-preview');
    const img = document.getElementById('transport-light-preview-img');

    if (!preview || !img) return;

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewTransportDarkImage(input) {
    const preview = document.getElementById('transport-dark-preview');
    const img = document.getElementById('transport-dark-preview-img');

    if (!preview || !img) return;

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}


function loadTicketsAdmin() {
    console.log('🎫 Loading tickets admin...');
    const container = document.getElementById('tickets-list');
    if (!container) {
        console.error('❌ tickets-list container not found');
        return;
    }

    container.innerHTML = `
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Logo</th>
                    <th>Nama Layanan</th>
                    <th>Rute/Deskripsi</th>
                    <th>Jenis</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tickets-table-body">
            </tbody>
        </table>
    `;

    const tableBody = document.getElementById('tickets-table-body');
    let totalTickets = 0;

    console.log('🔍 Transport data for tickets:', dataTransportasi);

    for (const [transportType, tickets] of Object.entries(dataTransportasi)) {
        const typeName = transportTypesData.find(t => t.key === transportType)?.name || transportType;
        console.log(`🚀 Loading ${tickets.length} tickets for ${transportType}`);

        tickets.forEach((ticket, index) => {
            totalTickets++;
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><strong>${totalTickets}</strong></td>
                <td>
                    <img src="${ticket.logo}" alt="${ticket.name}" class="table-image" 
                         onerror="this.src='https://via.placeholder.com/60x40/3498db/ffffff?text=${encodeURIComponent(ticket.name.charAt(0))}'">
                </td>
                <td>
                    <div class="table-title">${ticket.name}</div>
                </td>
                <td>
                    <div class="table-description">${ticket.route}</div>
                </td>
                <td>
                    <span class="table-badge">${typeName}</span>
                </td>
                <td>
                    <div class="table-description">${ticket.price}</div>
                </td>
                <td>
                    <div class="table-actions">
                        <button class="btn-edit" title="Edit ${ticket.name}">
                            <i class="icon icon-edit"></i>
                        </button>
                        <button class="btn-delete" title="Hapus ${ticket.name}">
                            <i class="icon icon-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);

            // Add event listeners directly
            const editBtn = row.querySelector('.btn-edit');
            const deleteBtn = row.querySelector('.btn-delete');

            if (editBtn) {
                editBtn.addEventListener('click', () => {
                    console.log('Edit ticket clicked:', transportType, index);
                    editTicket(transportType, index);
                });
            }

            if (deleteBtn) {
                deleteBtn.addEventListener('click', () => {
                    console.log('Delete ticket clicked:', transportType, index);
                    deleteTicket(transportType, index);
                });
            }
        });
    }

    console.log(`✅ Loaded ${totalTickets} tickets total in table format`);

    // If no tickets, show empty state
    if (totalTickets === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="icon icon-ticket" style="font-size: 3rem; color: var(--teks-kedua); margin-bottom: 1rem;"></i>
                <h3>Belum Ada Layanan</h3>
                <p>Klik tombol "Tambah Layanan" untuk menambahkan layanan transportasi pertama.</p>
            </div>
        `;
    }
}

// Populate Transport Type Select
function populateTransportTypeSelect() {
    const select = document.getElementById('ticket-transport-type');
    if (!select) return;

    select.innerHTML = '<option value="">Pilih Jenis Transportasi</option>';

    const transportTypes = [
        { key: 'pesawat', name: 'Pesawat' },
        { key: 'kapal', name: 'Kapal' },
        { key: 'bus', name: 'Bus' }
    ];

    transportTypes.forEach(type => {
        const option = document.createElement('option');
        option.value = type.key;
        option.textContent = type.name;
        select.appendChild(option);
    });
}

// Show Add Ticket Form
function showAddTicketForm() {
    const form = document.getElementById('add-ticket-form');
    if (form) {
        form.style.display = 'block';

        // Reset form
        document.getElementById('ticket-transport-type').value = '';
        document.getElementById('ticket-name').value = '';
        document.getElementById('ticket-route').value = '';
        document.getElementById('ticket-price').value = '';
        document.getElementById('ticket-logo').value = '';

        // Hide preview
        const preview = document.getElementById('ticket-logo-preview');
        if (preview) {
            preview.style.display = 'none';
        }

        // Reset form title and button
        const formTitle = document.querySelector('#add-ticket-form h3');
        if (formTitle) {
            formTitle.textContent = 'Tambah Layanan Baru';
        }

        const saveButton = document.querySelector('#add-ticket-form .btn-primary');
        if (saveButton) {
            saveButton.textContent = 'Simpan';
            saveButton.onclick = addTicket;
        }

        // Populate transport type select
        populateTransportTypeSelect();
    }
}

// Hide Add Ticket Form
function hideAddTicketForm() {
    const form = document.getElementById('add-ticket-form');
    if (form) {
        form.style.display = 'none';
    }
}

// Add Ticket
async function addTicket() {
    const transportType = document.getElementById('ticket-transport-type').value;
    const name = document.getElementById('ticket-name').value.trim();
    const route = document.getElementById('ticket-route').value.trim();
    const price = document.getElementById('ticket-price').value.trim();
    const logoFile = document.getElementById('ticket-logo').files[0];

    if (!transportType || !name || !route || !price) {
        alert('Mohon lengkapi semua field yang diperlukan!');
        return;
    }

    let logoPath;

    if (logoFile) {
        try {
            // Generate filename for transport folder
            const timestamp = Date.now();
            const extension = logoFile.name.split('.').pop().toLowerCase();
            const filename = `${name.replace(/[^a-zA-Z0-9]/g, '').toLowerCase()}_${timestamp}.${extension}`;

            // Try to upload to server
            const formData = new FormData();
            formData.append('logoFile', logoFile);
            formData.append('type', 'transport_logo');
            formData.append('transportType', transportType);
            formData.append('filename', filename);

            const response = await fetch('upload.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                logoPath = result.data.file_path;
                console.log(`✅ Logo uploaded successfully: ${logoPath}`);
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.log('⚠️ Server upload failed, using local preview:', error.message);
            // Fallback to object URL for demo
            logoPath = URL.createObjectURL(logoFile);
            const timestamp = Date.now();
            const extension = logoFile.name.split('.').pop().toLowerCase();
            console.log(`📁 Logo would be saved as: ${transportType}/${name.replace(/[^a-zA-Z0-9]/g, '').toLowerCase()}_${timestamp}.${extension}`);
        }
    } else {
        // Use placeholder
        logoPath = `https://via.placeholder.com/100x60/3498db/ffffff?text=${encodeURIComponent(name)}`;
    }

    const newTicket = {
        id: Date.now(),
        name: name,
        route: route,
        price: price,
        logo: logoPath,
        transportType: transportType,
        dateAdded: new Date().toISOString()
    };

    if (!dataTransportasi[transportType]) {
        dataTransportasi[transportType] = [];
    }

    dataTransportasi[transportType].push(newTicket);

    simpanDataKePenyimpanan();

    loadTicketsAdmin();
    muatDanTampilkanSemuaLayanan();
    hideAddTicketForm();

    alert(`✅ Layanan "${name}" berhasil ditambahkan ke ${transportType}!`);
}

// Edit Ticket
function editTicket(transportType, index) {
    console.log('🔧 editTicket called with:', transportType, index);

    if (!dataTransportasi || !dataTransportasi[transportType]) {
        alert('❌ Data transportasi tidak tersedia untuk: ' + transportType);
        return;
    }

    if (index < 0 || index >= dataTransportasi[transportType].length) {
        alert('❌ Index ticket tidak valid: ' + index);
        return;
    }

    const ticket = dataTransportasi[transportType][index];
    console.log('✏️ Editing ticket:', ticket);

    // Show the form
    showAddTicketForm();

    // Populate form with existing data
    document.getElementById('ticket-transport-type').value = transportType;
    document.getElementById('ticket-name').value = ticket.name;
    document.getElementById('ticket-route').value = ticket.route;
    document.getElementById('ticket-price').value = ticket.price;

    // Show current logo if exists
    if (ticket.logo) {
        const preview = document.getElementById('ticket-logo-preview');
        const img = document.getElementById('ticket-preview-img');
        if (preview && img) {
            img.src = ticket.logo;
            preview.style.display = 'block';
        }
    }

    // Change form title and button
    const formTitle = document.querySelector('#add-ticket-form h3');
    if (formTitle) {
        formTitle.textContent = `Edit Layanan: ${ticket.name}`;
    }

    const saveButton = document.querySelector('#add-ticket-form .btn-primary');
    if (saveButton) {
        saveButton.textContent = 'Update';
        saveButton.onclick = () => updateTicket(transportType, index);
    }
}

// Update Ticket
async function updateTicket(transportType, index) {
    const name = document.getElementById('ticket-name').value.trim();
    const route = document.getElementById('ticket-route').value.trim();
    const price = document.getElementById('ticket-price').value.trim();
    const logoFile = document.getElementById('ticket-logo').files[0];

    if (!name || !route || !price) {
        alert('Mohon lengkapi semua field yang diperlukan!');
        return;
    }

    const ticket = dataTransportasi[transportType][index];
    ticket.name = name;
    ticket.route = route;
    ticket.price = price;

    // Update logo 
    if (logoFile) {
        try {
            const timestamp = Date.now();
            const extension = logoFile.name.split('.').pop().toLowerCase();
            const filename = `${name.replace(/[^a-zA-Z0-9]/g, '').toLowerCase()}_${timestamp}.${extension}`;

            const formData = new FormData();
            formData.append('logoFile', logoFile);
            formData.append('type', 'transport_logo');
            formData.append('transportType', transportType);
            formData.append('filename', filename);

            const response = await fetch('upload.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                ticket.logo = result.data.file_path;
                console.log(`✅ Logo updated successfully: ${ticket.logo}`);
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.log('⚠️ Server upload failed, using local preview:', error.message);
            ticket.logo = URL.createObjectURL(logoFile);
            const timestamp = Date.now();
            const extension = logoFile.name.split('.').pop().toLowerCase();
            console.log(`📁 Logo would be updated as: ${transportType}/${name.replace(/[^a-zA-Z0-9]/g, '').toLowerCase()}_${timestamp}.${extension}`);
        }
    }

    simpanDataKePenyimpanan();

    // Update tampilan
    loadTicketsAdmin();
    muatDanTampilkanSemuaLayanan();
    hideAddTicketForm();

    alert(`✅ Layanan "${name}" berhasil diperbarui!`);
}

// Delete Ticket
function deleteTicket(transportType, index) {
    const ticket = dataTransportasi[transportType][index];
    if (confirm(`Apakah Anda yakin ingin menghapus layanan "${ticket.name}"?`)) {
        // Hapus dari data
        dataTransportasi[transportType].splice(index, 1);

        simpanDataKePenyimpanan();

        // Update tampilan
        loadTicketsAdmin();
        muatDanTampilkanSemuaLayanan();

        alert(`✅ Layanan "${ticket.name}" berhasil dihapus!`);
    }
}

// Preview Ticket Logo
function previewTicketLogo(input) {
    const preview = document.getElementById('ticket-logo-preview');
    const img = document.getElementById('ticket-preview-img');

    if (!preview || !img) {
        console.error('Preview elements not found');
        return;
    }

    if (input.files && input.files[0]) {
        const file = input.files[0];

        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
            input.value = '';
            return;
        }

        // Validate file size (max 5MB)
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            const fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
            alert(`Ukuran file terlalu besar (${fileSizeMB}MB). Maksimal 5MB.`);
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
            preview.style.display = 'block';
            console.log('✅ Logo preview loaded');
        };

        reader.onerror = function () {
            alert('Gagal membaca file. Coba lagi.');
            input.value = '';
        };

        reader.readAsDataURL(file);
    }
}

// Remove Ticket Logo Preview
function removeTicketLogoPreview() {
    const preview = document.getElementById('ticket-logo-preview');
    const input = document.getElementById('ticket-logo');

    if (preview) {
        preview.style.display = 'none';
    }

    if (input) {
        input.value = '';
    }
}

/**
 *  * EKSPOR FUNGSI KE WINDOW OBJECT
 *  * Fungsi-fungsi ini diekspor agar bisa dipanggil dari HTML (onclick, dll)
 * Kami juga menyediakan alias untuk kompatibilitas dengan kode lama
 */

// Fungsi untuk admin
window.tampilkanLoginAdmin = showAdminLogin;
window.tutupLoginAdmin = closeAdminLogin;
window.cobaLoginAdmin = attemptAdminLogin;

// Alias untuk kompatibilitas
window.showAdminLogin = showAdminLogin;
window.closeAdminLogin = closeAdminLogin;
window.attemptAdminLogin = attemptAdminLogin;

// Fungsi utama website
window.pesanViaWhatsApp = pesanViaWhatsApp;
window.tanganiKlikJenisTransportasi = tanganiKlikJenisTransportasi;
window.filterKontenBerdasarkanJenisTransportasi = filterKontenBerdasarkanJenisTransportasi;

window.gulungKeBagian = gulungKeBagian;

// Alias untuk kompatibilitas dengan kode lama
window.orderViaWA = pesanViaWhatsApp;
window.handleTransportClick = tanganiKlikJenisTransportasi;
window.filterKontenBerdasarkanTransport = filterKontenBerdasarkanJenisTransportasi;

// Admin functions
window.showSection = showSection;
window.loadFacilitiesAdmin = loadFacilitiesAdmin;
window.showAddFacilityForm = showAddFacilityForm;
window.hideAddFacilityForm = hideAddFacilityForm;
window.addFacility = addFacility;
window.editFacility = editFacility;
window.updateFacility = updateFacility;
window.deleteFacility = deleteFacility;
window.previewFacilityImage = previewFacilityImage;
window.removeFacilityImagePreview = removeFacilityImagePreview;

// Transport types admin functions
window.loadTransportTypesAdmin = loadTransportTypesAdmin;
window.showAddTransportTypeForm = showAddTransportTypeForm;
window.hideAddTransportTypeForm = hideAddTransportTypeForm;
window.addTransportType = addTransportType;
window.editTransportType = editTransportType;
window.updateTransportType = updateTransportType;
window.previewTransportLightImage = previewTransportLightImage;
window.previewTransportDarkImage = previewTransportDarkImage;

// Tickets admin functions
window.loadTicketsAdmin = loadTicketsAdmin;
window.populateTransportTypeSelect = populateTransportTypeSelect;
window.showAddTicketForm = showAddTicketForm;
window.hideAddTicketForm = hideAddTicketForm;
window.addTicket = addTicket;
window.editTicket = editTicket;
window.updateTicket = updateTicket;
window.deleteTicket = deleteTicket;
window.previewTicketLogo = previewTicketLogo;
window.removeTicketLogoPreview = removeTicketLogoPreview;


function backToWebsite() {
    if (confirm('Apakah Anda yakin ingin kembali ke website utama?')) {
        window.location.href = 'index.html';
    }
}


/**
 *  * FUNGSI: MUAT INFORMASI PERUSAHAAN
 *  * Fungsi ini memperbarui informasi perusahaan di halaman website
 * Informasi diambil dari variabel global companyInfoData
 */
function muatInformasiPerusahaan() {
    console.log('🏢 Memuat informasi perusahaan...');

    // Update informasi kontak di bagian contact
    const infoKontak = document.querySelector('.contact-info');
    if (infoKontak) {
        infoKontak.innerHTML = `
            <div class="contact-item">
                <i class="icon icon-whatsapp"></i>
                <div>
                    <h4>WhatsApp</h4>
                    <p>+${companyInfoData.whatsapp || '62 821-5206-9585'}</p>
                </div>
            </div>
            <div class="contact-item">
                <i class="icon icon-route"></i>
                <div>
                    <h4>Alamat</h4>
                    <p>${companyInfoData.address || 'Jl. Cendana No.8, Tlk. Lerong Ulu, Kec. Sungai Kunjang<br>Kota Samarinda, Kalimantan Timur 75127'}</p>
                </div>
            </div>
            <div class="contact-item">
                <i class="icon icon-info"></i>
                <div>
                    <h4>Jam Operasional</h4>
                    <p>${companyInfoData.hours || 'Senin - Minggu: 08.00 - 22.00 WIB'}</p>
                </div>
            </div>
        `;
    }

    // Update informasi kontak di footer
    const infoKontakFooter = document.querySelector('footer .contact-info');
    if (infoKontakFooter) {
        infoKontakFooter.innerHTML = `
            <p><i class="icon icon-whatsapp"></i> +${companyInfoData.whatsapp || '62 821-5206-9585'}</p>
            <p><i class="icon icon-email"></i> ${companyInfoData.email || 'info@cendanatravel.com'}</p>
            <p><i class="icon icon-camera"></i> ${companyInfoData.instagram || '@cendanatravel_official'}</p>
        `;
    }

    // Update deskripsi di footer
    const deskripsiFooter = document.querySelector('footer .footer-section p');
    if (deskripsiFooter && companyInfoData.description) {
        deskripsiFooter.textContent = companyInfoData.description;
    }

    // Update link WhatsApp float button
    const tombolFloatWhatsApp = document.querySelector('.wa-float a');
    if (tombolFloatWhatsApp) {
        tombolFloatWhatsApp.href = `https://wa.me/${companyInfoData.whatsapp || '6282152069585'}`;
    }

    // Update semua tombol WhatsApp lainnya
    document.querySelectorAll('.btn-whatsapp, .whatsapp-btn').forEach(tombol => {
        const hrefSaatIni = tombol.getAttribute('href') || tombol.getAttribute('onclick');
        if (hrefSaatIni) {
            const nomorWhatsAppBaru = companyInfoData.whatsapp || '6282152069585';
            tombol.setAttribute('href', `https://wa.me/${nomorWhatsAppBaru}`);
            if (tombol.hasAttribute('onclick')) {
                tombol.setAttribute('onclick', `window.open('https://wa.me/${nomorWhatsAppBaru}', '_blank')`);
            }
        }
    });

    console.log('✅ Informasi perusahaan berhasil dimuat');
}

// Alias untuk kompatibilitas
window.loadCompanyInfo = muatInformasiPerusahaan;

// Load Info Admin
function loadCompanyInfoAdmin() {
    console.log('🏢 Loading company info admin...');
    console.log('✅ Company info admin loaded - using default HTML values');
}

// Update Company Info
function updateCompanyInfo() {
    companyInfoData.name = document.getElementById('company-name').value.trim();
    companyInfoData.whatsapp = document.getElementById('company-whatsapp').value.trim();
    companyInfoData.instagram = document.getElementById('company-instagram').value.trim();
    companyInfoData.email = document.getElementById('company-email').value.trim();
    companyInfoData.address = document.getElementById('company-address').value.trim();
    companyInfoData.hours = document.getElementById('company-hours').value.trim();

    const kolomDeskripsi = document.getElementById('company-description');
    if (kolomDeskripsi) {
        companyInfoData.description = kolomDeskripsi.value.trim();
    }

    simpanDataKePenyimpanan();

    if (typeof muatInformasiPerusahaan === 'function') {
        muatInformasiPerusahaan();
    }

    alert('✅ Informasi perusahaan berhasil diperbarui!');
    console.log('Informasi perusahaan diperbarui:', companyInfoData);
}

function resetAllData() {
    if (confirm('⚠️ RESET SEMUA DATA? Ini akan menghapus semua perubahan dan kembali ke data default.')) {
        localStorage.clear();
        location.reload();
    }
}

function perbaruiDataPerusahaanPaksa() {
    companyInfoData = COMPANY_CONFIG;
    localStorage.setItem('companyInfoData', JSON.stringify(companyInfoData));
    console.log('🔄 Data perusahaan dipaksa diperbarui');
    if (typeof muatInformasiPerusahaan === 'function') {
        muatInformasiPerusahaan();
    }
    alert('✅ Data perusahaan telah diperbarui dengan alamat yang benar!');
}

// Alias untuk kompatibilitas
window.forceRefreshCompanyData = perbaruiDataPerusahaanPaksa;

function showCompanyInfoSection() {
    document.querySelectorAll('.admin-section').forEach(section => {
        section.style.display = 'none';
    });

    const companySection = document.getElementById('company-info-section');
    if (companySection) {
        companySection.style.display = 'block';
    }

    document.querySelectorAll('.sidebar-menu li').forEach(li => li.classList.remove('active'));
    event.target.closest('li').classList.add('active');
}


async function saveCompanyInfo() {
    // Ambil data dari form
    const companyData = {
        name: document.getElementById('company-name').value,
        whatsapp: document.getElementById('company-whatsapp').value,
        instagram: document.getElementById('company-instagram').value,
        email: document.getElementById('company-email').value,
        address: document.getElementById('company-address').value,
        hours: document.getElementById('company-hours').value,
        description: document.getElementById('company-description').value
    };

    // Handle upload banner jika ada file baru
    const bannerFile = document.getElementById('company-banner').files[0];
    if (bannerFile) {
        try {
            // Validasi file
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(bannerFile.type)) {
                alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
                return;
            }

            const maxSize = 5 * 1024 * 1024; // 5MB
            if (bannerFile.size > maxSize) {
                alert('Ukuran file terlalu besar. Maksimal 5MB.');
                return;
            }

            // Coba upload ke server
            const formData = new FormData();
            formData.append('logoFile', bannerFile);
            formData.append('type', 'banner');
            formData.append('filename', 'bannercendana.png');

            const response = await fetch('upload.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                console.log('Banner uploaded successfully');
                updateHeroBackground();
            } else {
                console.log('Banner upload failed:', result.message);
            }
        } catch (error) {
            console.log('Banner upload error:', error.message);
            const objectURL = URL.createObjectURL(bannerFile);
            console.log('Demo mode: Banner would be saved as cendana/bannercendana.png');
        }
    }

    companyInfoData = { ...companyInfoData, ...companyData };

    // Simpan ke localStorage
    localStorage.setItem('companyInfoData', JSON.stringify(companyInfoData));

    // Update tampilan di halaman utama
    if (typeof muatInformasiPerusahaan === 'function') {
        muatInformasiPerusahaan();
    }

    alert('✅ Informasi perusahaan berhasil disimpan!');
}

function previewBanner(input) {
    const preview = document.getElementById('banner-preview');
    const img = document.getElementById('banner-preview-img');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeBannerPreview() {
    document.getElementById('company-banner').value = '';
    document.getElementById('banner-preview').style.display = 'none';
}

function updateHeroBackground() {
    const heroSection = document.querySelector('.hero');
    if (heroSection) {
        const timestamp = new Date().getTime();
        const newBackgroundImage = `url('cendana/bannercendana.png?t=${timestamp}')`;
        heroSection.style.backgroundImage = newBackgroundImage;
        console.log('Hero background updated with new banner - full brightness');
    }
}

/**
 *  * HANDLE FORM PENCARIAN JADWAL
 *  */
function handleScheduleSearch(event) {
    event.preventDefault();

    // Ambil nilai dari form
    const destination = document.getElementById('destination').value;
    const participants = document.getElementById('participants').value;
    const departureDate = document.getElementById('departure-date').value;
    const returnDate = document.getElementById('return-date').value;

    // Validasi
    if (!destination || !participants || !departureDate || !returnDate) {
        alert('Mohon lengkapi semua field yang diperlukan!');
        return;
    }

    // Format tanggal untuk ditampilkan
    const formatDate = (dateString) => {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    };

    // Buat pesan untuk WhatsApp
    const whatsappNumber = companyInfoData?.whatsapp || '6285821841529';
    const message = `Halo, saya ingin mencari jadwal perjalanan dengan detail berikut:

📍 Tujuan Wisata: ${destination}
👥 Jumlah Peserta: ${participants} orang
📅 Tanggal Berangkat: ${formatDate(departureDate)}
📅 Tanggal Pulang: ${formatDate(returnDate)}

Mohon informasi ketersediaan dan harga yang tersedia. Terima kasih!`;

    // Encode message untuk URL
    const encodedMessage = encodeURIComponent(message);
    const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;

    // Buka WhatsApp
    window.open(whatsappUrl, '_blank');
}

// Make functions globally accessible
window.backToWebsite = backToWebsite;
window.loadCompanyInfo = loadCompanyInfo;
window.loadCompanyInfoAdmin = loadCompanyInfoAdmin;
window.updateCompanyInfo = updateCompanyInfo;
window.showCompanyInfoSection = showCompanyInfoSection;
window.saveCompanyInfo = saveCompanyInfo;
window.previewBanner = previewBanner;
window.removeBannerPreview = removeBannerPreview;
window.resetAllData = resetAllData;
window.forceRefreshCompanyData = forceRefreshCompanyData;
window.handleScheduleSearch = handleScheduleSearch;

console.log('🎉 Cv. Cendana Travel Script Loaded Successfully!');

