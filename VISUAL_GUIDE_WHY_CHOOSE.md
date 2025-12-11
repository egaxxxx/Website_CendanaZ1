# 🎨 Visual Guide - Section "Mengapa Memilih Cendana Travel?"

## 📐 Layout Structure (Desktop View)

```
╔═══════════════════════════════════════════════════════════════════╗
║                    MENGAPA MEMILIH CENDANA TRAVEL?                ║
╠═══════════════════════════════╦═══════════════════════════════════╣
║                               ║                                   ║
║  [KEUNGGULAN KAMI]            ║  ┌─────────┐ ┌─────────┐ ┌─────┐ ║
║                               ║  │    ✓    │ │    ✓    │ │  ✓  │ ║
║  Mengapa Memilih              ║  │ Legal & │ │Layanan  │ │Aman │ ║
║  Cendana Travel?              ║  │Terperca-│ │  24/7   │ │&    │ ║
║                               ║  │   ya    │ │         │ │Terj.│ ║
║  Kami berkomitmen             ║  │Deskripsi│ │Deskripsi│ │Desk │ ║
║  memberikan pengalaman        ║  └─────────┘ └─────────┘ └─────┘ ║
║  perjalanan terbaik...        ║                                   ║
║                               ║                                   ║
║  ┌─────────────────────┐     ║  ┌─────────┐ ┌─────────┐        ║
║  │                     │     ║  │         │ │         │        ║
║  │   Foto Perjalanan   │     ║  │  Icon   │ │  Icon   │        ║
║  │                     │     ║  │         │ │         │        ║
║  │  ┌─────────────┐    │     ║  └─────────┘ └─────────┘        ║
║  │  │  10+ Tahun  │    │     ║  ┌─────────┐ ┌─────────┐        ║
║  │  │ Pengalaman  │    │     ║  │         │ │         │        ║
║  │  └─────────────┘    │     ║  │  Icon   │ │  Icon   │        ║
║  └─────────────────────┘     ║  │         │ │         │        ║
║                               ║  └─────────┘ └─────────┘        ║
╚═══════════════════════════════╩═══════════════════════════════════╝
```

## 🎯 Component Breakdown

### LEFT SIDE (Sticky Position)
```
┌─────────────────────────────┐
│ [KEUNGGULAN KAMI] (Badge)   │ ← Orange badge
│                             │
│ Mengapa Memilih             │ ← H2 Title (3rem, Bold 800)
│ Cendana Travel?             │ ← Gradient text
│                             │
│ Kami berkomitmen...         │ ← Description (1rem)
│ dengan standar...           │
│                             │
│ ┌─────────────────────────┐ │
│ │                         │ │
│ │   Travel Photo          │ │ ← Large image (aspect 4:5)
│ │                         │ │
│ │   ┌───────────────┐     │ │
│ │   │ 10+ Tahun     │     │ │ ← Overlay badge
│ │   │ Pengalaman    │     │ │   (white bg, shadow)
│ │   └───────────────┘     │ │
│ └─────────────────────────┘ │
└─────────────────────────────┘
Width: 400px (desktop)
Position: sticky top 120px
```

### RIGHT SIDE TOP (3 Benefit Cards)
```
┌─────────────────────────────────────────────────────┐
│  ┌───────────┐  ┌───────────┐  ┌───────────┐      │
│  │     ✓     │  │     ✓     │  │     ✓     │      │
│  │ Card #1   │  │ Card #2   │  │ Card #3   │      │
│  │           │  │           │  │           │      │
│  │ Legal &   │  │ Layanan   │  │ Aman &    │      │
│  │Terpercaya │  │  24/7     │  │ Terjamin  │      │
│  │           │  │           │  │           │      │
│  │Tim customer│  │Deskripsi  │  │Deskripsi  │      │
│  │service...  │  │lengkap    │  │lengkap    │      │
│  └───────────┘  └───────────┘  └───────────┘      │
└─────────────────────────────────────────────────────┘
Grid: repeat(3, 1fr)
Gap: 1.5rem
Card: white bg, rounded 16px, shadow
```

### RIGHT SIDE BOTTOM (2×2 Grid)
```
┌─────────────────────────────┐
│ ┌──────────┐  ┌──────────┐  │
│ │          │  │          │  │
│ │   🛡️     │  │    ⭐    │  │ ← Placeholder boxes
│ │          │  │          │  │   (dashed border)
│ └──────────┘  └──────────┘  │
│ ┌──────────┐  ┌──────────┐  │
│ │          │  │          │  │
│ │   🕒     │  │    👥    │  │
│ │          │  │          │  │
│ └──────────┘  └──────────┘  │
└─────────────────────────────┘
Grid: repeat(2, 1fr) × repeat(2, 1fr)
Gap: 1.5rem
Min-height: 150px each
```

## 🎨 Color Palette

```css
/* Background */
--section-bg: linear-gradient(180deg, #FAFAF8 0%, #FFFFFF 100%)

/* Cards */
--card-bg: #FFFFFF
--card-border: #E8E8E8
--card-shadow: 0 2px 8px rgba(0, 0, 0, 0.04)

/* Accent Colors */
--badge-bg: linear-gradient(135deg, #FFF5F0 0%, #FFE8DC 100%)
--badge-text: #D4956E
--title-gradient: linear-gradient(135deg, #D4956E 0%, #E8B89A 100%)

/* Check Icon */
--check-bg: linear-gradient(135deg, #FFF5F0 0%, #FFE8DC 100%)
--check-color: #D4956E
--check-hover-bg: linear-gradient(135deg, #D4956E 0%, #E8B89A 100%)
--check-hover-color: #FFFFFF
```

## 📱 Responsive Breakpoints

### Desktop (> 1200px)
```
├── Left: 400px width, sticky
└── Right: 1fr (flexible)
    ├── 3 cards horizontal
    └── 2×2 grid
```

### Tablet (768px - 1200px)
```
├── Left: 360px width
└── Right: 1fr
    ├── 3 cards vertical (stacked)
    └── 2×2 grid
```

### Mobile (< 768px)
```
└── Full width stacked
    ├── Left content (centered)
    │   ├── Badge
    │   ├── Title
    │   ├── Description
    │   └── Image (max-width 500px)
    ├── 3 benefit cards (stacked)
    └── 4 grid boxes (2×2)
```

## 🎯 Data Flow Diagram

```
┌────────────────────────────────────────────────────┐
│                  ADMIN PANEL                       │
│  admin.php → Tab "Mengapa Memilih Kami"            │
└───────────────────┬────────────────────────────────┘
                    │
                    │ CRUD Operations (POST)
                    ▼
┌────────────────────────────────────────────────────┐
│              DATABASE (MySQL)                      │
│  Table: why_choose_us                             │
│  ├── id (primary key)                             │
│  ├── title (varchar 255)                          │
│  ├── description (text)                           │
│  ├── icon (varchar 255)                           │
│  ├── sort_order (int) ← 1, 2, 3                  │
│  └── is_active (tinyint) ← 1 or 0                │
└───────────────────┬────────────────────────────────┘
                    │
                    │ SELECT * WHERE is_active=1
                    │ ORDER BY sort_order ASC LIMIT 3
                    ▼
┌────────────────────────────────────────────────────┐
│         PHP BACKEND (includes/home_...)           │
│  $whyChooseUs = getAllWhyChooseUs()               │
└───────────────────┬────────────────────────────────┘
                    │
                    │ Pass to template
                    ▼
┌────────────────────────────────────────────────────┐
│            FRONTEND (index.php)                   │
│  <div class="benefit-container">                  │
│    <?php foreach ($whyChooseUs as $item): ?>      │
│      <div class="benefit-card">...</div>          │
│    <?php endforeach; ?>                           │
│  </div>                                           │
└───────────────────┬────────────────────────────────┘
                    │
                    │ Styling
                    ▼
┌────────────────────────────────────────────────────┐
│          CSS (beranda-dynamic.css)                │
│  .benefit-container { grid 3 columns }            │
│  .benefit-card { white bg, shadow, hover }        │
│  .benefit-check-icon { orange gradient }          │
└────────────────────────────────────────────────────┘
```

## 🔧 Admin Panel Interface

### Form Fields
```
┌─────────────────────────────────────────┐
│ Tambah Poin "Mengapa Memilih Kami"     │
├─────────────────────────────────────────┤
│                                         │
│ Judul *                                 │
│ ┌─────────────────────────────────────┐ │
│ │ Legal & Terpercaya                  │ │
│ └─────────────────────────────────────┘ │
│                                         │
│ Deskripsi *                             │
│ ┌─────────────────────────────────────┐ │
│ │ Perusahaan travel resmi dengan      │ │
│ │ izin operasional lengkap...         │ │
│ └─────────────────────────────────────┘ │
│                                         │
│ Icon (opsional)                         │
│ ┌─────────────────────────────────────┐ │
│ │ [Choose File] No file chosen        │ │
│ └─────────────────────────────────────┘ │
│ Format: PNG/SVG (64×64px)               │
│                                         │
│ Sort Order                              │
│ ┌─────┐                                 │
│ │  1  │ (1 = paling depan)              │
│ └─────┘                                 │
│                                         │
│ ☑ Is Active (Tampilkan di website)     │
│                                         │
│ ┌────────┐  ┌─────────┐               │
│ │ Batal  │  │ Simpan  │               │
│ └────────┘  └─────────┘               │
└─────────────────────────────────────────┘
```

### List View
```
┌────────────────────────────────────────────────────────┐
│ Daftar Poin "Mengapa Memilih Kami"   [+ Tambah Poin] │
├──────┬──────────────────┬──────────────┬──────┬───────┤
│ Sort │ Judul            │ Deskripsi    │Status│ Aksi  │
├──────┼──────────────────┼──────────────┼──────┼───────┤
│  1   │ Legal & Terperca │ Perusahaan...│ Aktif│ ✏️ 🗑️ │
│  2   │ Layanan 24/7     │ Tim customer │ Aktif│ ✏️ 🗑️ │
│  3   │ Aman & Terjamin  │ Keamanan... │ Aktif│ ✏️ 🗑️ │
└──────┴──────────────────┴──────────────┴──────┴───────┘
```

## 🎬 User Flow

### Adding New Benefit
```
1. Login admin.php
   ↓
2. Click "Konten Beranda" sidebar
   ↓
3. Click tab "Mengapa Memilih Kami"
   ↓
4. Click "+ Tambah Poin Baru"
   ↓
5. Fill form:
   - Judul: "Legal & Terpercaya"
   - Deskripsi: "Perusahaan resmi..."
   - Sort Order: 1
   - Is Active: ✅
   ↓
6. Click "Simpan"
   ↓
7. Redirect to admin.php#konten-beranda
   ↓
8. Flash message: "Poin berhasil ditambahkan!"
   ↓
9. Open index.php → See new benefit card
```

## 📊 Database Schema

```sql
-- Table structure
CREATE TABLE `why_choose_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_sort_active` (`sort_order`, `is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample data
INSERT INTO `why_choose_us` VALUES
(1, 'Legal & Terpercaya', 'Perusahaan travel resmi dengan izin operasional lengkap', NULL, 1, 1, NOW(), NOW()),
(2, 'Layanan 24/7', 'Tim customer service yang responsif siap membantu Anda kapan saja', NULL, 2, 1, NOW(), NOW()),
(3, 'Aman & Terjamin', 'Jaminan keamanan dengan sertifikat kelaikan dan perlindungan data', NULL, 3, 1, NOW(), NOW());
```

## ✅ Testing Checklist

### Frontend Testing
```
☐ Desktop view (1920×1080)
  ☐ Left side sticky pada scroll
  ☐ 3 benefit cards horizontal
  ☐ 4 grid boxes (2×2)
  ☐ Spacing konsisten

☐ Tablet view (768px)
  ☐ Benefit cards jadi vertikal
  ☐ Layout tetap rapi

☐ Mobile view (375px)
  ☐ Stack semua elemen
  ☐ Foto max-width 500px
  ☐ Text centered

☐ Interactions
  ☐ Card hover effect (translateY -4px)
  ☐ Check icon hover (rotate + scale)
  ☐ Grid placeholder hover
```

### Backend Testing
```
☐ CRUD Operations
  ☐ Create new benefit
  ☐ Read/display benefits
  ☐ Update existing benefit
  ☐ Delete benefit
  ☐ Toggle active status

☐ Validations
  ☐ Required fields checked
  ☐ Sort order numeric
  ☐ File upload (max 5MB)
  ☐ Duplicate sort_order warning

☐ Data Display
  ☐ Only active items shown
  ☐ Max 3 benefits displayed
  ☐ Sorted by sort_order ASC
  ☐ Empty state handled
```

---

**Visual Guide Version:** 1.0
**Created:** 11 Desember 2025
**For:** Cendana Travel Admin Panel
**Status:** ✅ Complete & Accurate
