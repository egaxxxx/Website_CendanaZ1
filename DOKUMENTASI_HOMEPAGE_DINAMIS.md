# Dokumentasi Pengaturan Homepage Dinamis

## Fitur yang Telah Ditambahkan

### 1. Database
- Table `homepage_settings` untuk menyimpan semua konfigurasi halaman beranda
- Fields yang tersedia:
  - `company_name`: Nama perusahaan (muncul di navbar & footer)
  - `hero_title`: Judul utama hero section
  - `hero_subtitle`: Sub judul hero
  - `hero_description`: Deskripsi hero
  - `hero_background`: Path gambar background hero (optional)
  - `stats_years`: Nilai tahun pengalaman (contoh: "10+")
  - `stats_years_label`: Label tahun pengalaman
  - `stats_customers`: Jumlah pelanggan
  - `stats_customers_label`: Label pelanggan
  - `stats_rating`: Rating
  - `stats_rating_label`: Label rating
  - `footer_description`: Deskripsi footer
  - `footer_copyright`: Text copyright

### 2. Halaman Admin (Pengaturan)
Lokasi: `admin.php` → Menu "Pengaturan"

Form yang tersedia:
1. **Informasi Umum Perusahaan** (existing)
2. **Pengaturan Halaman Beranda** (NEW)
   - Nama Perusahaan untuk Navbar & Footer
   - Hero Section (judul, subtitle, deskripsi, background image)
   - Statistik (3 kartu: Tahun, Pelanggan, Rating)
   - Footer (deskripsi, copyright)

### 3. Frontend Dinamis
File yang diupdate: `index.php`

Elemen yang menjadi dinamis:
- ✅ Navbar: Nama perusahaan
- ✅ Hero Section:
  - Judul utama
  - Subtitle
  - Deskripsi
  - Background image (jika diupload)
- ✅ Statistik (3 cards)
- ✅ Footer:
  - Nama perusahaan
  - Deskripsi
  - Jam operasional
  - Copyright text

### 4. Functions
File: `includes/functions.php`

Fungsi baru:
- `getHomepageSettings()`: Ambil data pengaturan homepage
- `updateHomepageSettings($data)`: Update data pengaturan

## Cara Penggunaan

1. Login ke halaman admin
2. Klik menu "Pengaturan"
3. Scroll ke bawah ke section "Pengaturan Halaman Beranda"
4. Isi atau ubah data sesuai keinginan:
   - Nama perusahaan akan otomatis update di navbar dan footer
   - Upload background hero jika ingin mengubah background
   - Ubah teks judul, deskripsi, statistik, dll
5. Klik "Simpan Pengaturan Beranda"
6. Buka halaman index.php untuk melihat perubahan

## Upload Background Hero
- Format: JPG, PNG
- Maksimal: 5MB
- Background akan di-overlay dengan gradient hitam transparan
- Menggunakan background-attachment: fixed untuk efek parallax

## Note
- Semua data memiliki fallback default jika database kosong
- Background hero bersifat optional
- Perubahan langsung terlihat tanpa perlu clear cache
