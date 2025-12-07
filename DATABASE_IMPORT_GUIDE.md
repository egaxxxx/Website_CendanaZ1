# 🗄️ Panduan Import Database CV. Cendana Travel

## 📁 File Database

**File Utama:** `cendana_travel_complete.sql`

File ini menggabungkan semua tabel database dari:
- ✅ `database.sql` (tabel utama)
- ✅ `database_home_content.sql` (konten beranda dinamis)
- ✅ `database_homepage_settings.sql` (pengaturan homepage)

---

## 🚀 Cara Import ke phpMyAdmin

### Metode 1: Via phpMyAdmin (Recommended)

1. **Buka phpMyAdmin**
   ```
   http://localhost/phpmyadmin
   ```

2. **Login dengan kredensial:**
   - Username: `root`
   - Password: `Hananta123`

3. **Import Database:**
   - Klik tab **"Import"** di menu atas
   - Klik tombol **"Choose File"** / **"Pilih File"**
   - Pilih file: `cendana_travel_complete.sql`
   - Scroll ke bawah, klik tombol **"Go"** / **"Kirim"**

4. **Tunggu Proses Selesai**
   - Jika berhasil, akan muncul pesan sukses
   - Database `cendana_travel` akan otomatis dibuat

---

### Metode 2: Via Terminal/Command Line

```bash
# Masuk ke direktori file SQL
cd /srv/http/Website-Cendana

# Import database
mysql -u root -pHananta123 < cendana_travel_complete.sql

# Verifikasi import berhasil
mysql -u root -pHananta123 -e "USE cendana_travel; SHOW TABLES;"
```

---

## 📊 Isi Database

Database ini berisi **24 tabel** yang terbagi dalam 9 bagian:

### 1️⃣ Informasi Perusahaan (2 tabel)
- `company_info` - Info perusahaan (legacy)
- `contact_info` - Info kontak

### 2️⃣ Homepage Settings (1 tabel)
- `homepage_settings` ⭐ **UTAMA** - Semua pengaturan homepage dinamis

### 3️⃣ Konten Beranda Dinamis (4 tabel)
- `why_choose_us` ⭐ - Mengapa Memilih Kami
- `payment_steps` ⭐ - Cara Pembayaran
- `order_steps` ⭐ - Cara Memesan
- `legal_security` - Legalitas & Keamanan

### 4️⃣ Transportasi & Layanan (3 tabel)
- `transport_types` - Jenis transportasi (Pesawat, Kapal, Bus)
- `transport_services` - Detail layanan per jenis
- `facilities` - Fasilitas yang ditawarkan

### 5️⃣ Galeri & Media (3 tabel)
- `gallery` - Galeri foto utama
- `gallery_home_selection` - Galeri yang ditampilkan di beranda (max 3)
- `homepage_banners` - Banner homepage

### 6️⃣ FAQ (1 tabel)
- `faq` - Pertanyaan yang sering diajukan

### 7️⃣ Pemesanan (1 tabel)
- `bookings` - Data pemesanan tiket

### 8️⃣ Admin & Authentication (2 tabel)
- `admin_users` - Data admin
- `admin_sessions` - Session admin

### 9️⃣ Indexes
- Otomatis dibuat untuk performa optimal

---

## 🔐 Kredensial Default

### Database
- **Host:** `localhost`
- **Username:** `root`
- **Password:** `Hananta123`
- **Database Name:** `cendana_travel`

### Admin Panel
- **Username:** `admin`
- **Password:** `admin123`
- **URL:** `http://localhost/Website-Cendana/admin.php`

---

## ⚠️ Hal Penting yang Perlu Diketahui

### 1. Database Akan Di-Drop Otomatis
```sql
DROP DATABASE IF EXISTS cendana_travel;
```
⚠️ **PERHATIAN:** Jika database `cendana_travel` sudah ada, **akan dihapus** dan dibuat ulang!

**Backup dulu jika ada data penting:**
```bash
mysqldump -u root -pHananta123 cendana_travel > backup_$(date +%Y%m%d_%H%M%S).sql
```

### 2. Data Sample Sudah Termasuk
File ini sudah berisi data sample untuk:
- ✅ 3 jenis transportasi (Pesawat, Kapal, Bus)
- ✅ 11 layanan transportasi
- ✅ 7 fasilitas
- ✅ 5 foto galeri
- ✅ 5 FAQ
- ✅ 5 booking sample
- ✅ 3 poin "Mengapa Memilih Kami"
- ✅ 3 langkah pembayaran
- ✅ 2 langkah cara memesan
- ✅ 4 poin legalitas & keamanan
- ✅ 1 user admin

### 3. Folder Upload yang Diperlukan
Pastikan folder-folder ini ada dan writable (chmod 755):
```
uploads/
├── icons/
├── order_steps/
├── gallery/
├── Beranda/
pesawat/
kapal/
bus/
JenisTransportasi/
```

Buat folder jika belum ada:
```bash
cd /srv/http/Website-Cendana
mkdir -p uploads/{icons,order_steps,gallery,Beranda}
mkdir -p {pesawat,kapal,bus,JenisTransportasi}
chmod -R 755 uploads pesawat kapal bus JenisTransportasi
```

---

## ✅ Verifikasi Import Berhasil

Setelah import, cek dengan query berikut:

```sql
-- Cek semua tabel
USE cendana_travel;
SHOW TABLES;

-- Cek data homepage settings
SELECT company_name, hero_title, hero_subtitle FROM homepage_settings;

-- Cek data mengapa memilih kami
SELECT id, title FROM why_choose_us;

-- Cek data cara pembayaran
SELECT id, title FROM payment_steps;

-- Cek data cara memesan
SELECT id, title FROM order_steps;

-- Cek admin user
SELECT username, full_name FROM admin_users;
```

Atau via terminal:
```bash
mysql -u root -pHananta123 cendana_travel -e "SHOW TABLES;"
```

---

## 🔄 Jika Import Gagal

### Error: "File too large"
Jika file terlalu besar untuk phpMyAdmin:

1. **Edit php.ini:**
```ini
upload_max_filesize = 128M
post_max_size = 128M
max_execution_time = 600
```

2. **Restart web server:**
```bash
sudo systemctl restart php-fpm
sudo systemctl restart nginx
# atau
sudo systemctl restart apache2
```

3. **Atau gunakan terminal:**
```bash
mysql -u root -pHananta123 < cendana_travel_complete.sql
```

### Error: "Access Denied"
Cek kredensial database di file `config/database.php`

### Error: "Table already exists"
Database lama masih ada. Hapus dulu:
```sql
DROP DATABASE cendana_travel;
```
Kemudian import ulang.

---

## 📞 Support

Jika ada masalah saat import, cek:
1. ✅ Kredensial database sudah benar
2. ✅ MySQL/MariaDB sudah running
3. ✅ User `root` punya privilege CREATE DATABASE
4. ✅ File `cendana_travel_complete.sql` tidak corrupt

---

## 📝 Changelog

**Version 2.0** (6 Desember 2025)
- ✅ Menggabungkan 3 file SQL menjadi 1 file
- ✅ Struktur database terorganisir dalam 9 bagian
- ✅ Ditambahkan indexes untuk performa
- ✅ Ditambahkan foreign key constraints
- ✅ Data sample lengkap
- ✅ Siap import langsung ke phpMyAdmin

---

**File:** `cendana_travel_complete.sql`  
**Size:** ~35 KB  
**Format:** UTF-8  
**Database:** MySQL 5.7+ / MariaDB 10.3+  
**Charset:** utf8mb4 (support emoji)
