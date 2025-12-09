# 🌍 CRUD Jelajahi Dunia - Service Cards

## 📋 Ringkasan Fitur Baru
Tanggal: 9 Desember 2025  
Modul: **Jelajahi Dunia - Card Layanan**  
Section: "Jelajahi Dunia, Kapan Saja & Dimana Saja"

---

## ✨ Fitur yang Ditambahkan

### 1. **Database Baru: `service_cards`**
Tabel untuk menyimpan data card layanan di section "Jelajahi Dunia" homepage.

**Struktur Tabel:**
```sql
- id (PK, AUTO_INCREMENT)
- title (varchar 255) - Judul layanan
- description (text) - Deskripsi layanan
- image (varchar 255) - Path gambar atau URL
- features (text) - JSON array untuk fitur-fitur (opsional)
- button_text (varchar 100) - Teks tombol CTA
- button_link (varchar 255) - Link tujuan tombol
- is_featured (tinyint) - 1=Card besar, 0=Card kecil
- badge_text (varchar 50) - Badge label (Terpopuler, Best Deal, dll)
- sort_order (int) - Urutan tampil
- is_active (tinyint) - Status aktif/nonaktif
- created_at, updated_at (timestamp)
```

**Data Awal (3 cards):**
1. **Tiket Pesawat** (Featured) - Badge: Terpopuler
2. **Tiket Bus Premium** (Regular)
3. **Tiket Kapal Laut** (Regular)

---

### 2. **Tab Admin Baru**
Tab "Jelajahi Dunia" ditambahkan di **paling depan** (sebelum "Mengapa Memilih Kami")

**Lokasi:** Admin Panel → Konten Beranda → Tab "Jelajahi Dunia"

**Icon:** 🌍 (fa-globe)

---

### 3. **Tabel Admin Profesional**
- ✓ Header dengan background yang jelas
- ✓ Hover effect pada baris
- ✓ Preview gambar 120x80px
- ✓ Badge indicator (Featured/Regular)
- ✓ Status badge dengan icon ✓/✗
- ✓ Urutan tampil dengan badge rounded
- ✓ Empty state informatif

**Kolom Tabel:**
| Gambar | Judul | Deskripsi | Featured | Urutan | Status | Aksi |
|--------|-------|-----------|----------|---------|---------|------|

---

### 4. **Modal Popup CRUD**
Modal popup dengan form lengkap untuk tambah/edit card layanan.

**Field Form:**
1. **Judul Layanan*** (required)
   - Input text
   - Placeholder: "Contoh: Tiket Pesawat"

2. **Deskripsi*** (required)
   - Textarea (3 rows)
   - Placeholder: "Jelaskan layanan ini secara detail..."

3. **Gambar** (opsional - 2 metode)
   - **Upload File**: JPG, PNG (max 5MB)
   - **URL**: Paste link gambar (dari Unsplash, dll)
   - Preview gambar saat edit

4. **Fitur-fitur** (opsional)
   - Textarea (multiline)
   - Setiap baris = 1 fitur
   - Hanya untuk card Featured
   - Contoh:
     ```
     Penerbangan Internasional & Domestik
     Proses Check-in Mudah
     Garansi Harga Terbaik
     ```

5. **Teks Tombol**
   - Input text
   - Default: "Pesan Sekarang"

6. **Link Tombol**
   - Input text
   - Default: "pemesanan.php"

7. **Badge Text** (opsional)
   - Input text
   - Contoh: "Terpopuler", "Best Deal"

8. **Featured Card?**
   - Select dropdown
   - Options: Regular (Kecil) / Featured (Besar)

9. **Urutan Tampil**
   - Input number
   - Auto-increment default

---

### 5. **Fungsi PHP CRUD Lengkap**
File: `includes/home_content_functions.php`

**Functions:**
- `getAllServiceCards()` - Get semua card
- `getServiceCardById($id)` - Get card by ID
- `createServiceCard($data, $image_file)` - Tambah card baru
- `updateServiceCard($id, $data, $image_file)` - Update card
- `deleteServiceCard($id)` - Hapus card
- `uploadServiceCardImage($file)` - Upload gambar

**Upload Folder:** `uploads/service_cards/`

---

### 6. **JavaScript Functions**
**Data Object:**
```javascript
const serviceCardsData = {
    1: { title: "...", description: "...", image: "...", ... },
    2: { ... }
};
```

**Functions:**
- `openServiceCardModal(mode, id)` - Open modal (add/edit)
- `closeServiceCardModal()` - Close modal
- `loadServiceCardData(id)` - Load data untuk edit
- `editServiceCard(id)` - Trigger edit modal

**Special Handler:**
- Form submit event untuk convert features textarea → JSON array

---

## 🎨 Perbedaan Featured vs Regular Card

| Aspek | Featured Card | Regular Card |
|-------|---------------|--------------|
| **Ukuran** | Besar (full width) | Kecil (grid 2 kolom) |
| **Layout** | Horizontal (image + content) | Vertical (stacked) |
| **Badge** | Ditampilkan di pojok | Tidak ada |
| **Features** | Ditampilkan (bullet list) | Tidak ditampilkan |
| **Image Size** | 1200x600px (landscape) | 800x500px |
| **Database Flag** | `is_featured = 1` | `is_featured = 0` |

---

## 📁 File yang Dibuat/Diubah

### File Baru:
1. **database_service_cards.sql** - Script SQL create table & data awal

### File Diubah:
1. **admin.php**
   - Handler POST untuk CRUD service_cards (lines ~186)
   - Load data serviceCards (line ~3098)
   - Tab navigation updated (line ~3078)
   - Tab content HTML service-cards-tab (lines ~3106-3285)
   - Modal popup HTML (lines ~3215-3285)
   - JavaScript data object (lines ~5415)
   - JavaScript functions (lines ~5625-5680)

2. **includes/home_content_functions.php**
   - Functions CRUD service_cards (lines ~482-620)

---

## 🎯 Cara Penggunaan

### Tambah Card Baru:
1. Login ke Admin Panel
2. Klik **Konten Beranda**
3. Klik tab **"Jelajahi Dunia"** (paling kiri)
4. Klik **"+ Tambah Card Baru"**
5. Modal popup muncul
6. Isi form:
   - Judul layanan
   - Deskripsi
   - Upload gambar ATAU paste URL gambar
   - Tambah fitur (jika Featured)
   - Set button text & link
   - Tambah badge (opsional)
   - Pilih Featured atau Regular
   - Set urutan tampil
7. Klik **"Simpan"**

### Edit Card:
1. Di tabel, klik tombol **Edit** (✏️)
2. Modal muncul dengan data ter-load
3. Preview gambar saat ini ditampilkan
4. Ubah data yang diperlukan
5. Upload gambar baru atau paste URL baru (opsional)
6. Klik **"Simpan"**

### Hapus Card:
1. Klik tombol **Hapus** (🗑️)
2. Konfirmasi muncul
3. Klik **OK**

---

## 🔧 Technical Details

### Upload Image
**2 Metode:**

1. **File Upload:**
   - Langsung upload dari komputer
   - Disimpan di: `uploads/service_cards/`
   - Filename: `service_[uniqid].[ext]`

2. **Image URL:**
   - Paste URL dari website lain
   - Tidak di-download, langsung pakai URL
   - Cocok untuk Unsplash, Pexels, dll

### Features Handling
**Flow:**
1. User input di textarea (1 baris = 1 fitur)
2. JavaScript convert ke JSON array saat submit
3. Disimpan di database sebagai JSON string
4. Saat edit, JSON array di-convert kembali ke textarea

**Example:**
```javascript
// Input textarea:
Penerbangan Internasional
Proses Check-in Mudah

// Converted to JSON:
["Penerbangan Internasional", "Proses Check-in Mudah"]

// Stored in DB:
'["Penerbangan Internasional","Proses Check-in Mudah"]'
```

---

## ✅ Testing Checklist

- [x] Tabel service_cards berhasil dibuat
- [x] Data awal (3 cards) ter-insert
- [x] Tab "Jelajahi Dunia" muncul paling depan
- [x] Tombol "Tambah Card Baru" membuka modal
- [x] Modal form ter-display dengan benar
- [x] Form validation berfungsi (required fields)
- [x] Upload gambar bekerja
- [x] Paste URL gambar bekerja
- [x] Features textarea convert ke JSON
- [x] Data tersimpan ke database
- [x] Tabel ter-update setelah submit
- [x] Tombol edit membuka modal dengan data ter-load
- [x] Preview gambar saat edit
- [x] Update data berfungsi
- [x] Tombol hapus berfungsi dengan konfirmasi
- [x] Close modal dari button X / Batal / click outside
- [x] Hover effect pada tabel
- [x] Empty state ter-display saat tidak ada data
- [x] Featured badge ter-display dengan benar
- [x] Status badge ter-display dengan benar

---

## 🚀 Next Steps (Frontend Integration)

Untuk menampilkan data di frontend (`index.php`), perlu:

1. **Load data dari database:**
   ```php
   $serviceCards = getAllServiceCards();
   ```

2. **Replace hardcoded HTML dengan dynamic loop:**
   ```php
   <?php foreach ($serviceCards as $card): ?>
       <?php if ($card['is_featured']): ?>
           <!-- Featured card HTML -->
       <?php else: ?>
           <!-- Regular card HTML -->
       <?php endif; ?>
   <?php endforeach; ?>
   ```

3. **Handle features JSON:**
   ```php
   $features = json_decode($card['features'], true);
   foreach ($features as $feature) {
       echo "<li>✓ $feature</li>";
   }
   ```

---

## 📊 Database Query Examples

### Get all active cards:
```sql
SELECT * FROM service_cards 
WHERE is_active = 1 
ORDER BY sort_order ASC;
```

### Get featured card only:
```sql
SELECT * FROM service_cards 
WHERE is_active = 1 AND is_featured = 1 
ORDER BY sort_order ASC 
LIMIT 1;
```

### Get regular cards only:
```sql
SELECT * FROM service_cards 
WHERE is_active = 1 AND is_featured = 0 
ORDER BY sort_order ASC;
```

---

## 📝 Notes

1. **Featured Card:**
   - Hanya 1 card yang sebaiknya featured
   - Card besar dengan fitur lengkap
   - Posisi paling atas/kiri

2. **Regular Cards:**
   - Bisa lebih dari 1
   - Card kecil tanpa features list
   - Grid 2 kolom (responsive)

3. **Image Flexibility:**
   - Bisa upload lokal atau pakai URL
   - URL cocok untuk prototyping
   - Upload lokal lebih cepat di production

4. **Sort Order:**
   - Featured card biasanya order = 1
   - Regular cards order = 2, 3, dst
   - Auto-increment saat tambah baru

---

**Status:** ✅ Fully Implemented  
**Backend:** ✅ Complete (Database, CRUD, Admin UI)  
**Frontend:** ⏳ Pending (Perlu integrasi di index.php)  
**Last Updated:** 9 Desember 2025  
**Developer:** GitHub Copilot Assistant
