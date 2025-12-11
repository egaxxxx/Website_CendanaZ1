# 🎯 Quick Reference - Admin Panel Cendana Travel

## 🔐 Login Info
```
URL: http://localhost/cendanaz/admin.php
User: admin
Pass: admin123
```

## 📍 Menu Navigation

| Menu | Fungsi | Icon |
|------|--------|------|
| **Dashboard** | Overview statistik | 📊 |
| **Kelola Beranda** | Banner hero section | 🖼️ |
| **Kelola Transportasi** | Pesawat, Kapal, Bus | ✈️ |
| **Galeri** | Upload foto galeri | 📸 |
| **Kontak** | Info kontak perusahaan | 📞 |
| **FAQ** | Pertanyaan umum | ❓ |
| **Konten Beranda** | Section beranda dinamis | 🏠 |
| **Pengaturan** | Info perusahaan | ⚙️ |

## 🏠 Konten Beranda - Tab Menu

### 1️⃣ **Jelajahi Dunia**
- Card layanan wisata
- Upload gambar destinasi
- Badge HOT/NEW
- Featured card (ukuran besar)

### 2️⃣ **Mengapa Memilih Kami** ⭐
- **3 Benefit Cards** (horizontal)
- Tampil di kanan atas
- Sort order: 1, 2, 3
- Ikon centang otomatis

**Layout Saat Ini:**
```
┌────────────────┬─────────────────────┐
│ Judul          │ ✅ Legal           │
│ Deskripsi      │ ✅ Layanan 24/7    │
│ Foto Besar     │ ✅ Aman            │
│ (10+ Tahun)    │ [4 Grid 2×2]       │
└────────────────┴─────────────────────┘
```

### 3️⃣ **Cara Pembayaran**
- Langkah-langkah bayar
- Icon Font Awesome
- Urutan step 1, 2, 3...

### 4️⃣ **Cara Memesan**
- Langkah-langkah booking
- Icon Font Awesome
- Urutan step 1, 2, 3...

### 5️⃣ **Galeri Beranda**
- Pilih foto dari galeri utama
- Tampilkan di homepage
- Atur urutan tampil

## ⚡ Quick Actions

### Tambah Benefit "Mengapa Memilih Kami"
```
1. Klik "Konten Beranda"
2. Tab "Mengapa Memilih Kami"
3. Klik "+ Tambah Poin Baru"
4. Isi:
   - Judul: "Legal & Terpercaya"
   - Deskripsi: "Perusahaan resmi..."
   - Sort Order: 1 (untuk card pertama)
   - Is Active: ✅ (centang)
5. Simpan
```

### Upload Foto Galeri
```
1. Klik "Galeri"
2. Klik "+ Tambah Foto"
3. Upload gambar (max 5MB)
4. Isi judul & deskripsi
5. Pilih kategori
6. Simpan
```

### Update Banner Hero
```
1. Klik "Kelola Beranda"
2. Klik "+ Tambah Banner"
3. Upload gambar 1920×600px
4. Isi judul & subtitle
5. Atur urutan tampil
6. Simpan
```

## 🎨 Design Guidelines

### Benefit Cards (3 Cards)
- **Judul:** 2-4 kata
- **Deskripsi:** 1-2 kalimat
- **Sort Order:** 1, 2, 3
- **Max Display:** Hanya 3 cards
- **Icon:** Otomatis (ikon centang)

### Service Cards (Jelajahi Dunia)
- **Gambar:** 800×600px
- **Judul:** 3-5 kata
- **Badge:** HOT, NEW, POPULAR
- **Featured:** 1-2 cards max

## 🐛 Quick Troubleshooting

| Masalah | Solusi |
|---------|--------|
| Benefit tidak muncul | Cek is_active ✅ & sort_order 1-3 |
| Layout berantakan | Clear cache: Ctrl + F5 |
| Gambar tidak muncul | Cek folder `uploads/` permissions |
| Data tidak tersimpan | Cek console browser (F12) |

## 📁 Folder Structure

```
cendanaz/
├── admin.php (Admin Panel)
├── index.php (Homepage)
├── beranda-dynamic.css (Styling)
├── config/
│   └── database.php
├── includes/
│   ├── functions.php
│   ├── home_functions.php
│   └── home_content_functions.php
└── uploads/
    ├── gallery/
    ├── pesawat/
    ├── kapal/
    └── bus/
```

## 🎯 Priority Actions

**Untuk "Mengapa Memilih Cendana Travel?"**
1. ✅ Tambah 3 benefit cards (sort_order: 1, 2, 3)
2. ✅ Set semua is_active = checked
3. ✅ Buka index.php → Verifikasi tampilan
4. ✅ Test responsive (resize browser)

## 📞 Need Help?

1. Cek browser console (F12)
2. Cek PHP error log
3. Clear browser cache
4. Refresh page

---

**Last Updated:** 11 Desember 2025
**Version:** Admin Panel 2.0
**Status:** ✅ Fully Functional
