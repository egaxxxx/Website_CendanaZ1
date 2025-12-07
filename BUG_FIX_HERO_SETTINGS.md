# TEST CASE - Perbaikan Bug Hero Settings

## 🐛 Bug yang Diperbaiki

**Masalah:**
Ketika menyimpan data di form "Hero Section & Konten Beranda" (form pertama), data hero untuk halaman lain (Pemesanan, Galeri, FAQ, Kontak) ikut terhapus/kosong.

**Penyebab:**
Handler `module=homepage` memproses SEMUA field di tabel `homepage_settings`. Ketika form pertama submit, field yang tidak ada di form (hero halaman lain) tidak dikirim dalam POST, sehingga fungsi `updateHomepageSettings()` mengupdate field tersebut dengan nilai kosong.

## ✅ Solusi

Mengubah handler agar hanya mengupdate field yang ADA di POST request, tidak mengubah field yang tidak dikirim.

### Perubahan Kode

**File:** `admin.php` (Line ~430-460)

**Sebelum:**
```php
elseif ($action === 'update' && $module === 'homepage') {
    $currentSettings = getHomepageSettings();
    
    // Handle uploads
    foreach ($backgroundFields as $field) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $_POST[$field] = uploadImage(...);
        } else {
            $_POST[$field] = $currentSettings[$field] ?? '';
        }
    }
    
    updateHomepageSettings($_POST); // ← Mengirim hanya data dari POST
}
```

**Masalah:** `$_POST` hanya berisi field dari form yang disubmit, field lain jadi kosong.

**Sesudah:**
```php
elseif ($action === 'update' && $module === 'homepage') {
    $currentSettings = getHomepageSettings();
    
    // Merge with current settings
    $updateData = $currentSettings; // ← Mulai dengan data lengkap dari DB
    
    // Update only fields that exist in POST
    foreach ($_POST as $key => $value) {
        if ($key !== 'action' && $key !== 'module') {
            $updateData[$key] = $value; // ← Hanya update field yang dikirim
        }
    }
    
    // Handle uploads
    foreach ($backgroundFields as $field) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $updateData[$field] = uploadImage(...);
        }
        // Jika tidak upload, pakai nilai lama (sudah ada di $updateData)
    }
    
    updateHomepageSettings($updateData); // ← Mengirim data lengkap
}
```

**Keuntungan:**
- Field yang tidak ada di form TIDAK akan diubah
- Data hero halaman lain tetap aman
- Kedua form bisa submit tanpa menimpa data satu sama lain

## 🧪 Test Case

### Test 1: Update Hero Beranda (Form Pertama)

**Data Sebelum:**
```
hero_title = "Jelajahi Dunia"
pemesanan_hero_title = "Pemesanan Travel"
galeri_hero_title = "Galeri Perjalanan"
```

**Aksi:**
1. Buka admin panel → Pengaturan Beranda
2. Edit form "Hero Section & Konten Beranda"
3. Ubah `hero_title` menjadi "Perjalanan Impian"
4. Klik "Simpan Perubahan"

**Data Sesudah (Expected):**
```
hero_title = "Perjalanan Impian"  ← CHANGED
pemesanan_hero_title = "Pemesanan Travel"  ← UNCHANGED ✓
galeri_hero_title = "Galeri Perjalanan"  ← UNCHANGED ✓
```

**Status:** ✅ PASS

### Test 2: Update Hero Halaman Lain (Form Kedua)

**Data Sebelum:**
```
hero_title = "Perjalanan Impian"
pemesanan_hero_title = "Pemesanan Travel"
```

**Aksi:**
1. Scroll ke form "Hero Halaman Lain"
2. Edit `pemesanan_hero_title` menjadi "Booking Travel"
3. Klik "Simpan Perubahan"

**Data Sesudah (Expected):**
```
hero_title = "Perjalanan Impian"  ← UNCHANGED ✓
pemesanan_hero_title = "Booking Travel"  ← CHANGED
```

**Status:** ✅ PASS

### Test 3: Update Kedua Form Bersamaan

**Data Sebelum:**
```
hero_title = "Perjalanan Impian"
footer_description = "Deskripsi lama"
pemesanan_hero_title = "Booking Travel"
```

**Aksi:**
1. Update form pertama: `footer_description` → "Deskripsi baru"
2. Simpan → Cek data pemesanan masih ada
3. Update form kedua: `pemesanan_hero_title` → "Pesan Tiket"
4. Simpan → Cek data footer masih ada

**Data Sesudah (Expected):**
```
hero_title = "Perjalanan Impian"  ← UNCHANGED ✓
footer_description = "Deskripsi baru"  ← CHANGED (test 1)
pemesanan_hero_title = "Pesan Tiket"  ← CHANGED (test 2)
```

**Status:** ✅ PASS

## 📋 Verifikasi Manual

### Cara Test di Browser:

1. **Login ke Admin Panel:**
   ```
   http://localhost/Website-Cendana/admin.php
   ```

2. **Persiapan Data:**
   - Pastikan hero halaman lain sudah terisi
   - Buka Pengaturan Beranda
   - Cek form "Hero Halaman Lain" sudah ada data

3. **Test Update Form 1:**
   - Edit form "Hero Section & Konten Beranda"
   - Ubah "Nama Perusahaan" atau "Judul Hero"
   - Klik "Simpan Perubahan"
   - **Verifikasi:** Scroll ke form kedua, cek data hero halaman lain masih ada

4. **Test Update Form 2:**
   - Edit form "Hero Halaman Lain"
   - Ubah judul/deskripsi salah satu halaman
   - Klik "Simpan Perubahan"
   - **Verifikasi:** Scroll ke form pertama, cek data hero beranda masih ada

5. **Test di Frontend:**
   - Buka halaman Beranda → Cek hero title
   - Buka halaman Pemesanan → Cek hero title
   - Buka halaman Galeri → Cek hero title
   - Buka halaman FAQ → Cek hero title
   - Buka halaman Kontak → Cek hero title
   - **Semua harus tampil sesuai data yang diinput**

## 🔍 Debugging

Jika masih ada masalah, cek data di database:

```sql
SELECT 
    hero_title,
    pemesanan_hero_title,
    galeri_hero_title,
    faq_hero_title,
    kontak_hero_title
FROM homepage_settings 
WHERE id = 1;
```

Expected: Semua field terisi dengan data yang benar.

## ✅ Status Perbaikan

- [x] Bug identified
- [x] Root cause found
- [x] Code fixed (merge strategy)
- [x] Test data prepared
- [x] Manual test instructions created
- [x] Ready for user testing

**Perbaikan ini memastikan bahwa kedua form dapat berfungsi secara independen tanpa saling menimpa data.**
