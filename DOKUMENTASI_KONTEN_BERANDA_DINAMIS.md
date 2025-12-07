# DOKUMENTASI LENGKAP - KONTEN BERANDA DINAMIS
## CV. Cendana Travel

---

## 📋 RINGKASAN

Fitur **Konten Beranda Dinamis** memungkinkan admin untuk mengelola SEMUA konten yang ditampilkan di halaman beranda website melalui panel admin, tanpa perlu mengedit kode HTML/CSS.

### Fitur yang Sudah Diimplementasikan:

✅ **5 Section Dinamis:**
1. Mengapa Memilih Kami (Why Choose Us)
2. Cara Pembayaran (Payment Steps)
3. Bagaimana Cara Memesan (Order Steps)
4. Galeri Perjalanan Beranda (Gallery Home Selection)
5. Legalitas & Keamanan (Legal Security)

✅ **Menu Admin Terpisah:** "Konten Beranda" (terpisah dari "Pengaturan Beranda")

✅ **CRUD Lengkap:** Create, Read, Update, Delete untuk semua section

✅ **Upload Gambar:** Icon dan foto untuk setiap konten

✅ **Urutan Tampilan:** Admin bisa mengatur urutan tampil

✅ **Status Aktif/Nonaktif:** Toggle visibility tanpa menghapus data

---

## 🗄️ STRUKTUR DATABASE

### Tabel yang Dibuat:

```sql
1. why_choose_us          - Mengapa Memilih Kami (icon, title, description)
2. payment_steps          - Cara Pembayaran (icon, title, description)
3. order_steps            - Cara Memesan (image, title, description)
4. gallery_home_selection - Galeri Beranda (max 3 foto dari tabel gallery)
5. legal_security         - Legalitas & Keamanan (icon, title, description)
```

### Field Umum di Setiap Tabel:

```
- id              (Primary Key)
- title           (Judul konten)
- description     (Deskripsi lengkap)
- icon/image      (Path ke file gambar)
- sort_order      (Urutan tampil, semakin kecil = semakin depan)
- is_active       (1 = tampil, 0 = hidden)
- created_at      (Timestamp pembuatan)
- updated_at      (Timestamp update terakhir)
```

### Import Database:

```bash
cd /srv/http/Website-Cendana
mysql -u root cendana_travel < database_home_content.sql
```

✅ **Database sudah di-import dan berisi data default!**

---

## 📁 FILE YANG DITAMBAHKAN/DIUBAH

### 1. File Database

- **`database_home_content.sql`** - Schema dan data default untuk 5 tabel baru

### 2. File PHP Functions

- **`includes/home_content_functions.php`** - Semua fungsi CRUD untuk konten beranda
  - `getAllWhyChooseUs()`, `createWhyChooseUs()`, `updateWhyChooseUs()`, `deleteWhyChooseUs()`
  - `getAllPaymentSteps()`, `createPaymentStep()`, `updatePaymentStep()`, `deletePaymentStep()`
  - `getAllOrderSteps()`, `createOrderStep()`, `updateOrderStep()`, `deleteOrderStep()`
  - `getAllGalleryHomeSelection()`, `createGalleryHomeSelection()`, `updateGalleryHomeSelection()`, `deleteGalleryHomeSelection()`
  - `getAllLegalSecurity()`, `createLegalSecurity()`, `updateLegalSecurity()`, `deleteLegalSecurity()`
  - `uploadIcon()`, `uploadOrderStepImage()` - Helper functions untuk upload file

### 3. File Admin Panel

- **`admin.php`**
  - ✅ Tambah menu "Konten Beranda" di sidebar (baris ~2256)
  - ✅ Tambah section "Konten Beranda" dengan 5 tab (baris ~2818-3600)
  - ✅ Tambah handler POST untuk CRUD operations (baris ~67-250)
  - ✅ Tambah JavaScript functions untuk toggle form (baris ~5078-5140)

### 4. File Customer Frontend

- **`index.php`**
  - ✅ Include `home_content_functions.php` (baris ~5)
  - ✅ Load dynamic content dari database (baris ~10-14)
  - ✅ Section "Mengapa Memilih Kami" - dynamic loop (baris ~207-226)
  - ✅ Section "Cara Pembayaran" - dynamic loop (baris ~254-268)
  - ✅ Section "Bagaimana Cara Memesan" - dynamic loop (baris ~360-393)
  - ✅ Section "Galeri Perjalanan" - dynamic cards (baris ~404-438)
  - ✅ Section "Legalitas & Keamanan" - dynamic grid (baris ~469-485)

### 5. Folder Upload

```
uploads/
├── icons/           ← Icon untuk Why Choose, Payment Steps, Legal Security
└── order_steps/     ← Foto untuk Bagaimana Cara Memesan
```

✅ **Folder sudah dibuat dengan permission 755**

---

## 🎨 CARA MENGGUNAKAN ADMIN PANEL

### Akses Menu Konten Beranda

1. Login ke admin panel: `http://localhost/Website-Cendana/admin.php`
2. Klik menu **"Konten Beranda"** di sidebar (icon grid)
3. Pilih tab yang ingin dikelola:
   - 🔘 Mengapa Memilih Kami
   - 💳 Cara Pembayaran
   - 🛒 Cara Memesan
   - 🖼️ Galeri Beranda
   - 🛡️ Legalitas & Keamanan

---

### 1️⃣ MENGAPA MEMILIH KAMI

**Fungsi:** Menampilkan keunggulan/benefit perusahaan

**Field:**
- Icon (upload gambar SVG/PNG, opsional)
- Judul Poin (contoh: "Legal & Terpercaya")
- Deskripsi (penjelasan benefit)
- Urutan Tampil (angka, semakin kecil = lebih depan)

**Cara:**
1. Klik "Tambah Poin Baru"
2. Upload icon (opsional, jika tidak ada akan tampil icon default)
3. Isi judul dan deskripsi
4. Klik "Simpan"
5. Poin akan langsung muncul di beranda

**Catatan:**
- Disarankan 3-4 poin agar tidak terlalu ramai
- Icon sebaiknya berformat SVG atau PNG transparan

---

### 2️⃣ CARA PEMBAYARAN

**Fungsi:** Menjelaskan langkah-langkah pembayaran

**Field:**
- Icon (upload gambar, opsional)
- Judul Langkah (contoh: "Transfer Bank")
- Deskripsi (penjelasan langkah)
- Urutan Tampil

**Cara:**
1. Klik "Tambah Langkah Baru"
2. Upload icon (opsional)
3. Isi judul langkah dan deskripsi detail
4. Klik "Simpan"

**Catatan:**
- Disarankan 3-5 langkah
- Section ini ditampilkan dalam format **horizontal scroll** di frontend

---

### 3️⃣ BAGAIMANA CARA MEMESAN

**Fungsi:** Tutorial step-by-step cara memesan tiket

**Field:**
- Foto Langkah (upload gambar JPG/PNG, **disarankan upload foto sendiri**)
- Judul Langkah (contoh: "Pilih Layanan")
- Deskripsi (penjelasan langkah)
- Urutan Tampil

**Cara:**
1. Klik "Tambah Langkah Baru"
2. Upload foto yang relevan (ukuran landscape, minimal 800x600px)
3. Isi judul dan deskripsi
4. Klik "Simpan"

**Catatan:**
- Layout **alternating** (kiri-kanan bergantian)
- Foto langkah 1, 3, 5, ... di kiri
- Foto langkah 2, 4, 6, ... di kanan
- Jika tidak upload foto, akan tampil placeholder dari Unsplash

---

### 4️⃣ GALERI PERJALANAN (BERANDA)

**Fungsi:** Menampilkan 3 foto pilihan dari galeri utama di beranda

**Field:**
- Pilih Foto (dropdown dari tabel `gallery`)
- Deskripsi Foto (edit/tulis ulang deskripsi)
- Urutan Tampil

**Cara:**
1. Klik "Pilih Foto (Maks 3)"
2. Pilih foto dari dropdown (foto diambil dari menu Galeri)
3. Tulis deskripsi singkat
4. Klik "Simpan"

**VALIDASI PENTING:**
- ⚠️ **MAKSIMAL 3 FOTO** yang dapat ditampilkan di beranda
- Jika sudah ada 3 foto, tombol "Pilih Foto" akan disabled
- Hapus salah satu foto lama jika ingin mengganti

**Catatan:**
- Foto ditampilkan dalam format **polaroid cards** dengan efek 3D
- Pastikan foto dari galeri sudah di-upload terlebih dahulu di menu "Galeri"

---

### 5️⃣ LEGALITAS & KEAMANAN

**Fungsi:** Menampilkan kredibilitas dan keamanan perusahaan

**Field:**
- Icon (upload gambar, opsional)
- Judul (contoh: "Terdaftar Resmi")
- Deskripsi (penjelasan detail)
- Urutan Tampil

**Cara:**
1. Klik "Tambah Poin Baru"
2. Upload icon (opsional)
3. Isi judul dan deskripsi
4. Klik "Simpan"

**Catatan:**
- Ditampilkan dalam **grid 2x2** di frontend
- Disarankan 4 poin untuk layout yang seimbang
- Fokus pada legalitas, sertifikat, keamanan transaksi, privasi data

---

## 🔧 FITUR TAMBAHAN

### Toggle Status Aktif/Nonaktif

Setiap konten memiliki status badge:
- 🟢 **Aktif** - Ditampilkan di website
- 🔴 **Nonaktif** - Hidden dari website (data tetap tersimpan)

Cara toggle status: (fitur ini bisa dikembangkan dengan tombol toggle)

### Urutan Tampilan (Sort Order)

- Semakin **kecil** angka sort_order, semakin **depan** posisi tampil
- Contoh: sort_order 1, 2, 3, 4 akan tampil berurutan dari atas ke bawah
- Bisa diubah saat create/update konten

### Upload Gambar

**Format yang Didukung:**
- Icon: JPG, JPEG, PNG, GIF, SVG, WEBP
- Foto Order Steps: JPG, JPEG, PNG, WEBP

**Ukuran Maksimal:**
- Icon: 2MB
- Foto: 5MB

**Path Upload:**
- Icon: `uploads/icons/`
- Order Steps: `uploads/order_steps/`

**Auto-Delete:**
- Saat delete konten, file gambar otomatis terhapus dari server
- Saat update dengan upload baru, file lama otomatis terhapus

---

## 🚀 TESTING FITUR

### Test di Admin Panel:

1. ✅ Login ke admin panel
2. ✅ Klik menu "Konten Beranda"
3. ✅ Test create data di setiap tab
4. ✅ Upload icon/foto
5. ✅ Test delete data
6. ✅ Cek notifikasi sukses/error

### Test di Customer Frontend:

1. ✅ Buka `http://localhost/Website-Cendana/index.php`
2. ✅ Scroll ke section "Mengapa Memilih Kami" - cek data muncul
3. ✅ Scroll ke section "Cara Pembayaran" - cek data muncul
4. ✅ Scroll ke section "Bagaimana Cara Memesan" - cek data & foto muncul
5. ✅ Scroll ke section "Galeri Perjalanan" - cek max 3 foto polaroid
6. ✅ Scroll ke section "Legalitas & Keamanan" - cek data muncul

### Test Upload:

```bash
# Test permission folder upload
ls -la uploads/
# Output expected:
# drwxr-xr-x icons/
# drwxr-xr-x order_steps/
```

---

## 📊 DATA DEFAULT

Database sudah berisi data default untuk semua section:

### 1. Why Choose Us (3 poin)
- Legal & Terpercaya
- Layanan 24/7
- Aman & Terjamin

### 2. Payment Steps (3 langkah)
- Pilih Layanan
- Hubungi Admin
- Lakukan Pembayaran

### 3. Order Steps (2 langkah)
- Pilih Layanan
- Hubungi Admin

### 4. Gallery Home Selection (0 foto)
- Kosong, admin harus memilih foto dari galeri

### 5. Legal Security (4 poin)
- Terdaftar Resmi
- Lisensi Operasional
- Transaksi Aman
- Perlindungan Data

**Admin dapat mengedit/hapus data default dan menambahkan data baru sesuai kebutuhan!**

---

## 🔒 KEAMANAN

✅ **SQL Injection Prevention:**
- Semua query menggunakan **Prepared Statements**
- Input di-escape dengan `bind_param()`

✅ **XSS Prevention:**
- Output di-escape dengan `htmlspecialchars()`

✅ **File Upload Security:**
- Validasi ekstensi file
- Validasi ukuran file
- Rename file dengan `uniqid()` untuk menghindari overwrite

✅ **Authentication:**
- Admin panel dilindungi dengan session login
- Redirect to login jika belum login

✅ **PRG Pattern (Post-Redirect-Get):**
- Setelah create/update/delete → redirect untuk mencegah duplicate submission

---

## 🛠️ TROUBLESHOOTING

### Problem: "Gagal menambahkan poin"

**Solusi:**
1. Cek permission folder `uploads/icons/` dan `uploads/order_steps/`:
   ```bash
   chmod 755 uploads/icons/
   chmod 755 uploads/order_steps/
   ```
2. Cek ukuran file upload tidak melebihi batas
3. Cek format file sesuai yang didukung

### Problem: "Foto galeri tidak muncul di beranda"

**Solusi:**
1. Pastikan foto sudah ada di menu "Galeri" (tabel `gallery`)
2. Pastikan belum ada 3 foto (max limit)
3. Cek path file foto di database benar

### Problem: "Data tidak muncul di frontend"

**Solusi:**
1. Cek status data di admin: harus "Aktif"
2. Clear browser cache (Ctrl+F5)
3. Cek error log PHP: `tail -f /var/log/php/error.log`

### Problem: "Upload foto gagal"

**Solusi:**
1. Cek permission folder upload:
   ```bash
   ls -la uploads/
   # Harus: drwxr-xr-x (755)
   ```
2. Cek ukuran file:
   - Icon: max 2MB
   - Foto: max 5MB
3. Cek format file:
   - Icon: jpg, png, svg, webp, gif
   - Foto: jpg, png, webp

---

## 📝 CATATAN PENTING

### Perbedaan "Pengaturan Beranda" vs "Konten Beranda"

**Pengaturan Beranda:**
- Hero section (judul, subtitle, background)
- Statistik (tahun berdiri, pelanggan, rating)
- Footer (tentang kami, copyright)
- Hero halaman lain (Pemesanan, Galeri, FAQ, Kontak)

**Konten Beranda:** ← FITUR BARU INI
- Mengapa Memilih Kami
- Cara Pembayaran
- Bagaimana Cara Memesan
- Galeri Beranda (3 foto pilihan)
- Legalitas & Keamanan

### Backup Database

Sebelum testing, backup database:

```bash
mysqldump -u root cendana_travel > backup_before_home_content_$(date +%Y%m%d).sql
```

### Update Frontend

Jika menambah/update konten:
1. Data langsung tersimpan di database
2. Refresh browser (Ctrl+F5) untuk lihat perubahan
3. Tidak perlu edit file HTML/CSS

---

## 🎯 NEXT STEPS / IMPROVEMENT IDEAS

### Fitur yang Bisa Ditambahkan:

1. **Edit Inline:**
   - Modal popup untuk edit data (saat ini edit belum diimplementasi)
   - Quick edit dari tabel

2. **Drag & Drop Sort:**
   - Ubah urutan dengan drag & drop (lebih user-friendly dari input angka)

3. **Bulk Actions:**
   - Aktifkan/nonaktifkan multiple items sekaligus
   - Delete multiple items

4. **Preview:**
   - Preview perubahan sebelum publish
   - Draft mode

5. **Image Optimization:**
   - Auto-resize dan compress image saat upload
   - Generate thumbnail

6. **Analytics:**
   - Track section mana yang paling dilihat pengunjung

---

## 👨‍💻 DEVELOPER NOTES

### Code Structure:

```
admin.php
├── POST Handlers (baris 67-250)
│   ├── module=why_choose
│   ├── module=payment_steps
│   ├── module=order_steps
│   ├── module=gallery_home
│   └── module=legal_security
├── Menu Navigation (baris 2256)
├── Section Konten Beranda (baris 2818-3600)
│   ├── Tab 1: Why Choose Us
│   ├── Tab 2: Payment Steps
│   ├── Tab 3: Order Steps
│   ├── Tab 4: Gallery Home
│   └── Tab 5: Legal Security
└── JavaScript Functions (baris 5078-5140)

index.php
├── Include Functions (baris 5)
├── Load Dynamic Data (baris 10-14)
├── Section Why Choose Us (baris 207-226)
├── Section Payment Steps (baris 254-268)
├── Section Order Steps (baris 360-393)
├── Section Gallery Home (baris 404-438)
└── Section Legal Security (baris 469-485)

includes/home_content_functions.php
├── Why Choose Us Functions (12 functions)
├── Payment Steps Functions (12 functions)
├── Order Steps Functions (12 functions)
├── Gallery Home Functions (8 functions)
├── Legal Security Functions (12 functions)
└── Helper Functions (upload, getMaxSortOrder)
```

### Database Schema:

Semua tabel mengikuti pattern yang sama:
```sql
CREATE TABLE table_name (
    id INT PRIMARY KEY AUTO_INCREMENT,
    icon/image VARCHAR(255),
    title VARCHAR(255),
    description TEXT,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

Kecuali `gallery_home_selection` yang hanya referensi ke tabel `gallery`:
```sql
CREATE TABLE gallery_home_selection (
    id INT PRIMARY KEY AUTO_INCREMENT,
    gallery_id INT REFERENCES gallery(id),
    description TEXT,
    sort_order INT DEFAULT 0,
    ...
);
```

---

## ✅ CHECKLIST IMPLEMENTASI

- [x] Create database tables (5 tables)
- [x] Create PHP functions (home_content_functions.php)
- [x] Add admin menu "Konten Beranda"
- [x] Create admin panel sections (5 tabs)
- [x] Implement POST handlers (CRUD operations)
- [x] Add JavaScript toggle functions
- [x] Update index.php frontend (5 sections)
- [x] Create upload folders (icons, order_steps)
- [x] Insert default data
- [x] Test all CRUD operations
- [x] Write documentation

---

## 📞 SUPPORT

Jika ada masalah atau pertanyaan, cek:

1. **Error Logs:**
   ```bash
   tail -f /var/log/php/error.log
   tail -f /var/log/apache2/error.log
   ```

2. **Database Connection:**
   ```bash
   mysql -u root -p cendana_travel
   SHOW TABLES LIKE '%_steps';
   ```

3. **File Permissions:**
   ```bash
   ls -la uploads/
   ```

---

**Selamat Menggunakan Fitur Konten Beranda Dinamis! 🎉**

Dokumentasi dibuat: 6 Desember 2025
Developer: AI Assistant
Website: CV. Cendana Travel
