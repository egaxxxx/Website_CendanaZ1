# 🚀 QUICK START - Konten Beranda Dinamis

## Langkah-langkah Cepat

### 1. Import Database (SUDAH SELESAI ✅)

```bash
mysql -u root cendana_travel < database_home_content.sql
```

### 2. Akses Admin Panel

1. Buka: `http://localhost/Website-Cendana/admin.php`
2. Login dengan kredensial admin
3. Klik menu **"Konten Beranda"** di sidebar

### 3. Kelola Konten (5 Tab Available)

#### 🔘 Tab 1: Mengapa Memilih Kami
- Klik "Tambah Poin Baru"
- Upload icon (opsional)
- Isi judul dan deskripsi
- Simpan

#### 💳 Tab 2: Cara Pembayaran  
- Klik "Tambah Langkah Baru"
- Upload icon (opsional)
- Isi judul langkah dan deskripsi
- Simpan

#### 🛒 Tab 3: Bagaimana Cara Memesan
- Klik "Tambah Langkah Baru"
- Upload foto langkah (disarankan!)
- Isi judul dan deskripsi
- Simpan

#### 🖼️ Tab 4: Galeri Perjalanan
- Klik "Pilih Foto (Maks 3)"
- Pilih foto dari galeri utama
- Edit deskripsi
- Simpan
- **PENTING:** Max 3 foto saja!

#### 🛡️ Tab 5: Legalitas & Keamanan
- Klik "Tambah Poin Baru"
- Upload icon (opsional)
- Isi judul dan deskripsi
- Simpan

### 4. Cek Hasil di Frontend

Buka: `http://localhost/Website-Cendana/index.php`

Scroll kebawah dan cek 5 section:
1. ✅ Mengapa Memilih Kami?
2. ✅ Cara Pembayaran
3. ✅ Bagaimana Cara Memesan?
4. ✅ Galeri Perjalanan (polaroid cards)
5. ✅ Legalitas & Keamanan

---

## 📌 Tips Penting

### Upload Gambar
- **Icon:** Format SVG/PNG transparan (max 2MB)
- **Foto:** Format JPG/PNG landscape (max 5MB)
- Folder: `uploads/icons/` dan `uploads/order_steps/`

### Urutan Tampil
- Angka kecil = muncul lebih dulu
- Contoh: 1, 2, 3, 4 → tampil berurutan

### Status Aktif
- 🟢 Aktif = Tampil di website
- 🔴 Nonaktif = Tersembunyi (data tidak dihapus)

### Data Default
Database sudah berisi data default untuk testing:
- Why Choose Us: 3 poin
- Payment Steps: 3 langkah
- Order Steps: 2 langkah
- Gallery Home: 0 foto (harus pilih manual)
- Legal Security: 4 poin

**Silakan edit/hapus dan tambahkan konten sendiri!**

---

## ⚠️ Troubleshooting Cepat

### Foto tidak muncul?
```bash
chmod 755 uploads/icons/
chmod 755 uploads/order_steps/
```

### Data tidak update di frontend?
- Clear browser cache (Ctrl+F5)
- Cek status data: harus "Aktif"

### Gagal upload?
- Cek ukuran file (max 2MB/5MB)
- Cek format file (jpg, png, svg, webp)

---

## 📖 Dokumentasi Lengkap

Baca file: `DOKUMENTASI_KONTEN_BERANDA_DINAMIS.md`

---

**Selamat Mencoba! 🎉**
