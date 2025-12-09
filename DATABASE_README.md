# 📦 DATABASE SETUP - CV. CENDANA TRAVEL

## 📋 Daftar Isi
1. [Import Database](#import-database)
2. [Backup & Restore](#backup--restore)
3. [Struktur Database](#struktur-database)
4. [Kredensial](#kredensial)
5. [Troubleshooting](#troubleshooting)

---

## 🚀 Import Database

### Metode 1: Via phpMyAdmin (Mudah)

1. **Buka phpMyAdmin** di browser:
   ```
   http://localhost/phpmyadmin
   ```

2. **Login** dengan kredensial:
   - Username: `root`
   - Password: `Hananta123`

3. **Klik tab "Import"** di menu atas

4. **Pilih file** `cendana_travel_complete.sql`

5. **Klik "Go"** atau "Kirim"

6. **Tunggu** hingga proses selesai (biasanya 5-10 detik)

7. **Verifikasi**: Cek apakah database `cendana_travel` muncul di sidebar kiri

✅ **SELESAI!** Database siap digunakan.

---

### Metode 2: Via Terminal/Command Line (Cepat)

```bash
# Masuk ke folder project
cd /srv/http/Website-Cendana

# Import database
mysql -u root -pHananta123 < cendana_travel_complete.sql

# Verifikasi import berhasil
mysql -u root -pHananta123 -e "USE cendana_travel; SHOW TABLES;"
```

✅ **SELESAI!** Database siap digunakan.

---

### Metode 3: Via Script Restore (Otomatis)

```bash
# Berikan permission execute (sudah dilakukan)
chmod +x restore_database.sh

# Jalankan script restore
./restore_database.sh
```

Script akan menanyakan:
- File SQL yang akan di-restore (ketik: `cendana_travel_complete.sql`)
- Konfirmasi restore (ketik: `y`)

✅ **SELESAI!** Database berhasil di-restore.

---

## 💾 Backup & Restore

### 🔵 Backup Database (Manual)

```bash
# Backup database ke file dengan timestamp
mysqldump -u root -pHananta123 cendana_travel > backup_$(date +%Y%m%d_%H%M%S).sql
```

### 🔵 Backup Database (Otomatis dengan Script)

```bash
# Jalankan script backup
./backup_database.sh
```

File backup akan tersimpan dengan format:
```
backup_cendana_travel_YYYYMMDD_HHMMSS.sql
```

### 🟢 Restore Database

```bash
# Restore dari file backup
mysql -u root -pHananta123 < backup_cendana_travel_YYYYMMDD_HHMMSS.sql
```

**ATAU** gunakan script:

```bash
./restore_database.sh
```

---

## 📊 Struktur Database

### Database: `cendana_travel`

Total **27 tabel** yang terbagi dalam 9 kategori:

### 1️⃣ Informasi Perusahaan
- `company_info` - Info perusahaan (legacy)
- `contact_info` - Info kontak
- `homepage_settings` - **[UTAMA]** Pengaturan homepage dinamis

### 2️⃣ Konten Beranda Dinamis (DIGUNAKAN FRONTEND)
- `why_choose_us` - Mengapa memilih kami (3 poin)
- `payment_steps` - Cara pembayaran (3 langkah)
- `order_steps` - Cara memesan (2-3 langkah)
- `legal_security` - Legalitas & keamanan (4 poin)

### 3️⃣ Transportasi & Layanan
- `transport_types` - Jenis transportasi (Pesawat, Kapal, Bus)
- `transport_services` - Layanan per jenis transportasi (11 layanan)
- `facilities` - Fasilitas yang ditawarkan (7 fasilitas)

### 4️⃣ Galeri & Media
- `gallery` - Galeri foto utama
- `gallery_home_selection` - Galeri di beranda (max 3)
- `homepage_banners` - Banner homepage

### 5️⃣ FAQ
- `faq` - Pertanyaan yang sering diajukan

### 6️⃣ Pemesanan
- `bookings` - Data pemesanan pelanggan

### 7️⃣ Admin & Authentication
- `admin_users` - User admin
- `admin_sessions` - Session admin

---

## 🔑 Kredensial

### Database
```
Host:     localhost
Username: root
Password: Hananta123
Database: cendana_travel
Port:     3306 (default)
```

### Admin Panel
```
URL:      http://localhost/Website-Cendana/admin.php
Username: admin
Password: admin123
```

### PhpMyAdmin
```
URL:      http://localhost/phpmyadmin
Username: root
Password: Hananta123
```

---

## 📁 Folder Upload yang Diperlukan

Pastikan folder-folder berikut ada dan memiliki permission write (755 atau 777):

```bash
# Buat folder upload jika belum ada
mkdir -p uploads/icons
mkdir -p uploads/order_steps
mkdir -p uploads/gallery
mkdir -p uploads/Beranda
mkdir -p uploads/bus
mkdir -p uploads/kapal
mkdir -p uploads/pesawat
mkdir -p JenisTransportasi

# Set permission
chmod -R 755 uploads/
chmod -R 755 JenisTransportasi/
```

---

## 🔍 Verifikasi Database

### Cek jumlah tabel:
```bash
mysql -u root -pHananta123 -e "USE cendana_travel; SELECT COUNT(*) as total_tables FROM information_schema.tables WHERE table_schema = 'cendana_travel';"
```

**Expected Result:** `27 tabel`

### Cek data konten beranda:
```bash
mysql -u root -pHananta123 -e "USE cendana_travel; 
SELECT 'why_choose_us' as tabel, COUNT(*) as jumlah FROM why_choose_us
UNION ALL
SELECT 'payment_steps', COUNT(*) FROM payment_steps
UNION ALL
SELECT 'order_steps', COUNT(*) FROM order_steps
UNION ALL
SELECT 'legal_security', COUNT(*) FROM legal_security;"
```

**Expected Result:**
- why_choose_us: 3 rows
- payment_steps: 3 rows
- order_steps: 2 rows
- legal_security: 4 rows

### Cek admin user:
```bash
mysql -u root -pHananta123 -e "USE cendana_travel; SELECT username, full_name, email FROM admin_users;"
```

**Expected Result:**
- Username: `admin`
- Full Name: `Administrator`
- Email: `admin@cendanatravel.com`

---

## ⚠️ Troubleshooting

### ❌ Error: "Access denied for user 'root'@'localhost'"

**Solusi:**
```bash
# Cek password MySQL Anda
mysql -u root -p
# Masukkan password saat diminta

# Jika password berbeda, edit file config/database.php
nano config/database.php
# Ganti password di line 11
```

---

### ❌ Error: "Database already exists"

**Solusi 1 (Aman - Backup dulu):**
```bash
# Backup database yang ada
mysqldump -u root -pHananta123 cendana_travel > backup_existing.sql

# Drop database lama
mysql -u root -pHananta123 -e "DROP DATABASE cendana_travel;"

# Import database baru
mysql -u root -pHananta123 < cendana_travel_complete.sql
```

**Solusi 2 (Langsung - HATI-HATI!):**
```bash
# Drop dan import langsung
mysql -u root -pHananta123 -e "DROP DATABASE IF EXISTS cendana_travel;"
mysql -u root -pHananta123 < cendana_travel_complete.sql
```

---

### ❌ Error: "File too large" di phpMyAdmin

**Solusi:**
1. Edit `php.ini`:
   ```ini
   upload_max_filesize = 50M
   post_max_size = 50M
   max_execution_time = 300
   ```

2. Restart web server:
   ```bash
   sudo systemctl restart httpd  # Arch/CentOS
   # atau
   sudo systemctl restart apache2  # Ubuntu/Debian
   ```

3. **ATAU** gunakan terminal:
   ```bash
   mysql -u root -pHananta123 < cendana_travel_complete.sql
   ```

---

### ❌ Error: "Foreign key constraint fails"

**Solusi:**
```bash
# Disable foreign key check sementara
mysql -u root -pHananta123 -e "SET FOREIGN_KEY_CHECKS=0;"

# Import database
mysql -u root -pHananta123 < cendana_travel_complete.sql

# Enable kembali foreign key check
mysql -u root -pHananta123 -e "SET FOREIGN_KEY_CHECKS=1;"
```

---

### ❌ Website menampilkan "Database connection failed"

**Solusi:**
1. Cek file `config/database.php`:
   ```bash
   cat config/database.php | grep "DB_"
   ```

2. Pastikan credentials sesuai:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', 'Hananta123');
   define('DB_NAME', 'cendana_travel');
   ```

3. Test koneksi:
   ```bash
   mysql -u root -pHananta123 -e "USE cendana_travel; SELECT 1;"
   ```

---

## 🔄 Update Database (Jika Ada Perubahan)

### Jika ada perubahan struktur tabel:

```bash
# 1. Backup data yang ada
./backup_database.sh

# 2. Drop database lama
mysql -u root -pHananta123 -e "DROP DATABASE cendana_travel;"

# 3. Import database baru
mysql -u root -pHananta123 < cendana_travel_complete.sql

# 4. Verifikasi
mysql -u root -pHananta123 -e "USE cendana_travel; SHOW TABLES;"
```

---

## 📝 Maintenance Rutin

### Backup Otomatis (Recommended)

Tambahkan ke crontab untuk backup harian:

```bash
# Edit crontab
crontab -e

# Tambahkan baris ini (backup setiap hari jam 02:00)
0 2 * * * cd /srv/http/Website-Cendana && ./backup_database.sh
```

### Cleanup Backup Lama (Opsional)

```bash
# Hapus backup yang lebih dari 30 hari
find /srv/http/Website-Cendana -name "backup_cendana_travel_*.sql" -type f -mtime +30 -delete
```

---

## 📞 Support & Contact

Jika ada masalah atau pertanyaan:

1. **Check logs:**
   ```bash
   tail -f /var/log/httpd/error_log  # Arch/CentOS
   # atau
   tail -f /var/log/apache2/error.log  # Ubuntu/Debian
   ```

2. **Check MySQL logs:**
   ```bash
   sudo tail -f /var/log/mysql/error.log
   ```

3. **Test database connection:**
   ```bash
   php -r "new mysqli('localhost', 'root', 'Hananta123', 'cendana_travel') or die('Connection failed');"
   ```

---

## ✅ Checklist Setelah Import

- [ ] Database `cendana_travel` terlihat di phpMyAdmin
- [ ] 27 tabel berhasil dibuat
- [ ] Website bisa diakses tanpa error
- [ ] Admin panel bisa login (admin/admin123)
- [ ] Halaman beranda menampilkan konten dinamis
- [ ] Folder uploads sudah dibuat dan punya permission
- [ ] Backup script sudah executable
- [ ] Test CRUD di admin panel

---

## 🎉 Selesai!

Database Anda sudah siap digunakan!

**Next Steps:**
1. ✅ Import database ← **Anda di sini**
2. ✅ Test website & admin panel
3. ✅ Upload gambar ke folder uploads
4. ✅ Setup backup otomatis
5. ✅ Go live!

---

**File Database:** `cendana_travel_complete.sql`  
**Ukuran:** ~50 KB  
**Total Tabel:** 27 tabel  
**Versi:** 2.0 (Consolidated)  
**Tanggal:** 6 Desember 2025  
**Status:** ✅ Ready to Use
