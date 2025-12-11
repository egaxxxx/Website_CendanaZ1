# 📋 Panduan Admin Panel - Kelola Konten Beranda

## ✅ Status Integrasi
**Semua fitur sudah terintegrasi dengan baik!** Admin panel Anda sudah memiliki fitur lengkap untuk mengelola konten beranda, termasuk section "Mengapa Memilih Cendana Travel?" yang baru didesain ulang.

---

## 🎯 Cara Mengakses Admin Panel

### 1. **Login ke Admin Panel**
```
URL: http://localhost/cendanaz/admin.php
Username: admin
Password: admin123
```

### 2. **Navigasi Sidebar**
Klik menu **"Konten Beranda"** di sidebar kiri dengan icon 🏠

---

## 📊 Fitur-Fitur yang Tersedia

### **Tab 1: Jelajahi Dunia** 🌍
**Fungsi:** Kelola card layanan di section "Jelajahi Dunia"
- ✅ Tambah card baru
- ✅ Upload gambar
- ✅ Atur badge "HOT", "NEW", dll
- ✅ Set featured card
- ✅ Atur urutan tampil

**Cara Pakai:**
1. Klik tab "Jelajahi Dunia"
2. Klik tombol "+ Tambah Card Baru"
3. Isi form:
   - **Judul**: Nama destinasi/layanan
   - **Deskripsi**: Penjelasan singkat
   - **Upload Gambar**: Pilih foto (JPG/PNG, max 5MB)
   - **Badge Text**: Tulis "HOT" atau "NEW" (opsional)
   - **Is Featured**: Centang jika ingin card lebih besar
   - **Sort Order**: Angka urutan (semakin kecil = semakin depan)
   - **Is Active**: Centang untuk tampilkan di website
4. Klik "Simpan"

---

### **Tab 2: Mengapa Memilih Kami** ✅
**Fungsi:** Kelola benefit cards di section "Mengapa Memilih Cendana Travel?"

**Layout Saat Ini (Sesuai Design Baru):**
```
┌─────────────────────────────────────────────────────────────┐
│  KIRI: Judul + Deskripsi + Foto Besar                      │
│  KANAN ATAS: 3 Benefit Cards (Legal, Layanan 24/7, Aman)   │
│  KANAN BAWAH: 4 Grid Placeholder (2×2)                     │
└─────────────────────────────────────────────────────────────┘
```

**Data yang Dikelola:**
- **3 Benefit Cards** yang ditampilkan horizontal di kanan atas
- Setiap card memiliki:
  - ✅ Ikon centang premium (otomatis)
  - ✅ Judul (contoh: "Legal & Terpercaya")
  - ✅ Deskripsi singkat

**Cara Pakai:**
1. Klik tab "Mengapa Memilih Kami"
2. Klik tombol "+ Tambah Poin Baru"
3. Isi form:
   - **Judul**: Nama benefit (contoh: "Legal & Terpercaya")
   - **Deskripsi**: Penjelasan singkat benefit
   - **Icon**: Upload ikon (opsional, karena sudah ada ikon centang default)
   - **Sort Order**: Urutan tampil (1, 2, 3 untuk 3 cards utama)
   - **Is Active**: Centang untuk tampilkan
4. Klik "Simpan"

**⚠️ Catatan Penting:**
- **Hanya 3 benefit pertama** yang akan ditampilkan di website (sesuai design)
- Sort order 1, 2, 3 akan muncul sebagai cards horizontal
- Jika ada lebih dari 3 data aktif, yang ditampilkan adalah 3 data dengan sort_order terkecil

---

### **Tab 3: Cara Pembayaran** 💳
**Fungsi:** Kelola langkah-langkah pembayaran

**Cara Pakai:**
1. Klik tab "Cara Pembayaran"
2. Klik "+ Tambah Langkah"
3. Isi form:
   - **Judul**: Nama langkah (contoh: "Pilih Metode Pembayaran")
   - **Deskripsi**: Penjelasan langkah
   - **Icon**: Class icon Font Awesome (contoh: "fas fa-credit-card")
   - **Step Number**: Nomor urut (1, 2, 3, dst)
   - **Is Active**: Centang untuk tampilkan
4. Klik "Simpan"

---

### **Tab 4: Cara Memesan** 🛒
**Fungsi:** Kelola langkah-langkah pemesanan

**Cara Pakai:**
(Sama seperti Cara Pembayaran)

---

### **Tab 5: Galeri Beranda** 🖼️
**Fungsi:** Pilih foto dari galeri utama untuk ditampilkan di beranda

**Cara Pakai:**
1. Klik tab "Galeri Beranda"
2. **Untuk menambahkan foto:**
   - Klik "+ Tambah ke Galeri Beranda"
   - Pilih foto dari dropdown (foto diambil dari menu Galeri)
   - Atur urutan tampil
   - Klik "Simpan"
3. **Untuk menghapus foto:**
   - Klik tombol "Hapus" pada foto yang ingin dihapus

---

## 🎨 Integrasi dengan Design Baru

### **Section "Mengapa Memilih Cendana Travel?"**

**Frontend (index.php):**
```php
<div class="why-main-grid">
    <!-- Left: Title + Description + Image -->
    <div class="why-content-left">
        <h2>Mengapa Memilih Cendana Travel?</h2>
        <p>Deskripsi...</p>
        <div class="why-large-image">
            <img src="..." alt="Travel">
        </div>
    </div>
    
    <!-- Right: 3 Benefit Cards + 4 Grid -->
    <div class="why-content-right">
        <!-- 3 Benefit Cards (dari database) -->
        <div class="benefit-container">
            <?php foreach ($whyChooseUs as $item): ?>
                <?php if ($benefitCount < 3): ?>
                    <div class="benefit-card">
                        <div class="benefit-check-icon">✓</div>
                        <div class="benefit-text">
                            <h3><?= $item['title'] ?></h3>
                            <p><?= $item['description'] ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        
        <!-- 4 Grid Placeholder (2×2) -->
        <div class="why-grid-2x2">
            <div class="grid-placeholder">🛡️</div>
            <div class="grid-placeholder">⭐</div>
            <div class="grid-placeholder">🕒</div>
            <div class="grid-placeholder">👥</div>
        </div>
    </div>
</div>
```

**Backend (admin.php):**
- Data disimpan di tabel `why_choose_us`
- Admin bisa CRUD (Create, Read, Update, Delete)
- Filter: hanya 3 data aktif pertama yang ditampilkan

---

## 📁 Struktur Database

### Tabel: `why_choose_us`
```sql
CREATE TABLE why_choose_us (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(255),
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Kolom:**
- `id`: ID unik
- `title`: Judul benefit (contoh: "Legal & Terpercaya")
- `description`: Deskripsi benefit
- `icon`: Path ikon (opsional)
- `sort_order`: Urutan tampil (1, 2, 3)
- `is_active`: Status aktif/nonaktif (1/0)

---

## 🔧 File-File Terkait

### **Frontend:**
1. **index.php** (line 234-303)
   - Section "Mengapa Memilih Cendana Travel?"
   - Mengambil data dari `$whyChooseUs`
   
2. **beranda-dynamic.css** (line 569-811)
   - Styling untuk section baru
   - Class: `.why-section-wrapper`, `.benefit-card`, `.why-grid-2x2`

### **Backend:**
1. **admin.php** (line 3130-3250)
   - Tab "Mengapa Memilih Kami"
   - Form CRUD

2. **includes/home_content_functions.php**
   - `getAllWhyChooseUs()` - Ambil semua data
   - `createWhyChooseUs()` - Tambah data baru
   - `updateWhyChooseUs()` - Update data
   - `deleteWhyChooseUs()` - Hapus data

---

## ✅ Checklist Fitur

### **Sudah Berfungsi:**
- ✅ Login admin panel
- ✅ Sidebar navigation "Konten Beranda"
- ✅ Tab "Mengapa Memilih Kami"
- ✅ Form tambah/edit benefit
- ✅ Upload ikon
- ✅ Set urutan tampil
- ✅ Toggle aktif/nonaktif
- ✅ Hapus benefit
- ✅ Frontend menampilkan 3 benefit cards
- ✅ Design responsive
- ✅ Layout persis seperti design (foto kiri bawah, 3 cards kanan atas, 4 grid kanan bawah)

### **Koneksi Database:**
- ✅ PHP mengambil data dari `why_choose_us`
- ✅ Filter: hanya 3 data aktif pertama (ORDER BY sort_order ASC LIMIT 3)
- ✅ Real-time update (POST-REDIRECT-GET pattern)

---

## 🎯 Cara Testing

### **1. Test Admin Panel:**
```bash
1. Login ke admin.php
2. Klik "Konten Beranda" di sidebar
3. Klik tab "Mengapa Memilih Kami"
4. Tambah 3 benefit baru:
   - Legal & Terpercaya (sort_order: 1)
   - Layanan 24/7 (sort_order: 2)
   - Aman & Terjamin (sort_order: 3)
5. Set semua is_active = checked
6. Simpan
```

### **2. Test Frontend:**
```bash
1. Buka index.php di browser
2. Scroll ke section "Mengapa Memilih Cendana Travel?"
3. Verifikasi layout:
   ✓ Kiri: Judul + Deskripsi + Foto besar
   ✓ Kanan Atas: 3 benefit cards horizontal
   ✓ Kanan Bawah: 4 grid placeholder (2×2)
4. Check responsiveness (resize browser)
```

---

## 🚀 Tips & Rekomendasi

### **Best Practices:**
1. **Urutan Tampil:**
   - Gunakan sort_order 1, 2, 3 untuk 3 benefit utama
   - Sisanya bisa 4, 5, dst (tidak akan ditampilkan)

2. **Konten Benefit:**
   - **Judul:** Singkat (2-4 kata)
   - **Deskripsi:** 1-2 kalimat pendek
   - **Contoh Bagus:**
     ```
     Judul: Legal & Terpercaya
     Deskripsi: Perusahaan travel resmi dengan izin operasional lengkap dan badan pemerintah yang kompeten.
     ```

3. **Upload Ikon:**
   - Format: PNG/SVG (transparan)
   - Ukuran: 64x64px atau 128x128px
   - Warna: Sesuai theme (coklat/peach)
   - **Note:** Ikon opsional karena sudah ada ikon centang default

4. **Responsive Design:**
   - Desktop (>1200px): Layout 2 kolom
   - Tablet (768-1200px): Benefit cards jadi 1 kolom
   - Mobile (<768px): Stack vertikal

---

## 🐛 Troubleshooting

### **Masalah 1: Benefit tidak muncul di website**
**Solusi:**
1. Cek di admin panel: apakah is_active = checked?
2. Cek sort_order: apakah 1, 2, atau 3?
3. Clear browser cache (Ctrl + F5)
4. Cek console browser (F12) untuk error

### **Masalah 2: Layout berantakan**
**Solusi:**
1. Cek file CSS: `beranda-dynamic.css` sudah ter-load?
2. Clear cache: `?v=<?= time() ?>` di link CSS
3. Cek responsive: resize browser window

### **Masalah 3: Foto tidak muncul**
**Solusi:**
1. Cek path foto di database
2. Pastikan file ada di folder `uploads/`
3. Cek permissions folder uploads (755)

---

## 📞 Kontak Support

Jika ada pertanyaan atau masalah:
1. Cek console browser (F12 → Console)
2. Cek PHP error log
3. Cek network tab untuk request failed

---

## 🎉 Summary

**Admin panel Anda sudah lengkap dan siap digunakan!**

✅ Semua fitur berfungsi dengan baik
✅ Integrasi frontend-backend sudah sempurna
✅ Design responsive dan modern
✅ Database terstruktur dengan baik
✅ CRUD operations complete

**Cara Cepat Mulai:**
1. Login admin.php
2. Klik "Konten Beranda"
3. Tab "Mengapa Memilih Kami"
4. Tambah 3 benefit
5. Buka index.php → Lihat hasilnya! 🎊

---

**Dokumentasi dibuat:** 11 Desember 2025
**Versi Admin Panel:** 2.0 (dengan fitur Konten Beranda lengkap)
**Status:** ✅ Production Ready
