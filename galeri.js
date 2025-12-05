/**
 * ============================================
 * GALERI.JS - CV. CENDANA TRAVEL
 * Script untuk mengelola galeri foto
 * ============================================
 */

// Fungsi untuk memuat galeri dari data fasilitas
function muatGaleri() {
    const galleryGrid = document.getElementById('gallery-grid');
    
    if (!galleryGrid) {
        console.error('Element gallery-grid tidak ditemukan');
        return;
    }

    // Cek ketersediaan data dengan berbagai kemungkinan nama variable
    const dataGaleri = window.DATA_FASILITAS_DEFAULT || window.DEFAULT_FACILITIES_DATA || [];
    
    console.log('Data galeri tersedia:', dataGaleri.length, 'items');
    console.log('Data galeri:', dataGaleri);

    // Cek apakah data fasilitas tersedia
    if (!dataGaleri || dataGaleri.length === 0) {
        console.warn('Data galeri kosong atau tidak ditemukan');
        galleryGrid.innerHTML = `
            <div class="gallery-empty">
                <i class="icon icon-image"></i>
                <p>Belum ada foto di galeri</p>
            </div>
        `;
        return;
    }

    // Bersihkan konten sebelumnya
    galleryGrid.innerHTML = '';

    // Tampilkan setiap item fasilitas sebagai galeri
    dataGaleri.forEach((item, index) => {
        const galleryItem = document.createElement('div');
        galleryItem.className = 'gallery-item';
        galleryItem.setAttribute('data-aos', 'fade-up');
        galleryItem.setAttribute('data-aos-delay', (index % 3) * 100);
        
        const imgPath = `uploads/${item.image}`;
        console.log(`Loading image ${index + 1}:`, imgPath);
        
        galleryItem.innerHTML = `
            <div class="gallery-image">
                <img src="${imgPath}" 
                     alt="${item.name}" 
                     onerror="console.error('Image failed to load:', this.src); this.style.display='none'; this.parentElement.innerHTML+='<p style=color:red>Failed to load image</p>'">
                <div class="gallery-overlay">
                    <div class="gallery-overlay-content">
                        <h3>${item.name}</h3>
                        <button class="gallery-view-btn" onclick="bukaModalGaleri(${item.id})">
                            <i class="icon icon-eye"></i>
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        galleryGrid.appendChild(galleryItem);
    });

    console.log(`✓ Berhasil memuat ${dataGaleri.length} foto galeri`);
}

// Fungsi untuk membuka modal galeri dengan detail
function bukaModalGaleri(itemId) {
    const modal = document.getElementById('galleryModal');
    const modalImg = document.getElementById('gallery-modal-img');
    const modalTitle = document.getElementById('gallery-modal-title');
    const modalDescription = document.getElementById('gallery-modal-description');
    
    if (!modal || !modalImg || !modalTitle || !modalDescription) {
        console.error('Element modal tidak ditemukan');
        return;
    }

    // Cari data item berdasarkan ID
    const dataGaleri = window.DATA_FASILITAS_DEFAULT || window.DEFAULT_FACILITIES_DATA || [];
    const item = dataGaleri.find(f => f.id === itemId);
    
    if (!item) {
        console.error('Item galeri tidak ditemukan:', itemId);
        return;
    }

    // Set konten modal
    modalImg.src = `uploads/${item.image}`;
    modalImg.alt = item.name;
    modalTitle.textContent = item.name;
    modalDescription.textContent = item.description;

    // Tampilkan modal
    modal.classList.add('active');
    document.body.style.overflow = 'hidden'; // Disable scroll

    // Event listener untuk menutup modal saat klik di luar gambar
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            tutupModalGaleri();
        }
    });
}

// Fungsi untuk menutup modal galeri
function tutupModalGaleri() {
    const modal = document.getElementById('galleryModal');
    
    if (!modal) {
        return;
    }

    modal.classList.remove('active');
    document.body.style.overflow = ''; // Enable scroll kembali
}

// Event listener untuk tombol ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        tutupModalGaleri();
    }
});

// Fungsi untuk mencoba memuat galeri dengan retry
function cobaMemuatGaleri(attempt = 1, maxAttempts = 5) {
    console.log(`Attempt ${attempt}/${maxAttempts} - Checking for config data...`);
    
    if (typeof window.DATA_FASILITAS_DEFAULT !== 'undefined' && window.DATA_FASILITAS_DEFAULT.length > 0) {
        console.log('✓ Config data found!', window.DATA_FASILITAS_DEFAULT.length, 'items');
        muatGaleri();
    } else if (attempt < maxAttempts) {
        console.warn(`⚠ Config data not ready, retrying in ${attempt * 100}ms...`);
        setTimeout(function() {
            cobaMemuatGaleri(attempt + 1, maxAttempts);
        }, attempt * 100);
    } else {
        console.error('✗ Failed to load config data after', maxAttempts, 'attempts');
        console.log('Window.DATA_FASILITAS_DEFAULT:', typeof window.DATA_FASILITAS_DEFAULT);
        console.log('Window keys with DATA:', Object.keys(window).filter(k => k.includes('DATA')));
        muatGaleri(); // Tampilkan empty state
    }
}

// Inisialisasi galeri saat halaman dimuat
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        console.log('=== DOMContentLoaded - Galeri.js ===');
        cobaMemuatGaleri();
    });
} else {
    console.log('=== DOM already loaded - Galeri.js ===');
    cobaMemuatGaleri();
}

// Fungsi tambahan untuk refresh galeri (jika diperlukan untuk update dinamis)
function refreshGaleri() {
    muatGaleri();
}

// Export fungsi untuk digunakan di file lain jika diperlukan
if (typeof window !== 'undefined') {
    window.muatGaleri = muatGaleri;
    window.bukaModalGaleri = bukaModalGaleri;
    window.tutupModalGaleri = tutupModalGaleri;
    window.refreshGaleri = refreshGaleri;
}
