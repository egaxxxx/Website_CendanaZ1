# Redesign Bagaimana Cara Memesan - Alternating Layout

## Deskripsi
Section "Bagaimana Cara Memesan?" di halaman beranda telah diredesign menggunakan **Alternating Layout** dengan gambar dan konten yang berseling (kiri-kanan), menciptakan visual flow yang lebih menarik dan modern sesuai dengan desain referensi foto kedua.

## Perubahan yang Dilakukan

### 1. File: `index.php`
**Lokasi:** Section Cara Pemesanan (Baris ~346)

**Perubahan:**
- Mengganti layout timeline vertikal dengan alternating horizontal layout
- Setiap step memiliki gambar dan konten yang berseling posisinya
- Step 1: Gambar kiri, konten kanan
- Step 2: Konten kiri, gambar kanan  
- Step 3: Gambar kiri, konten kanan

**Struktur HTML Baru:**
```html
<section class="booking-steps-alternating">
  - .section-header-booking
  - .booking-step-row .booking-step-left (Step 1)
    - .booking-step-image (kiri)
    - .booking-step-content (kanan)
  - .booking-step-row .booking-step-right (Step 2)
    - .booking-step-content (kiri)
    - .booking-step-image (kanan)
  - .booking-step-row .booking-step-left (Step 3)
    - .booking-step-image (kiri)
    - .booking-step-content (kanan)
</section>
```

### 2. File: `beranda-dynamic.css`
**Lokasi:** Section 7 - Booking Timeline (~798)

**Perubahan:**
- Mengganti CSS `.booking-timeline` dengan `.booking-steps-alternating`
- Implementasi CSS Grid dengan 2 kolom untuk alternating layout
- Menambahkan gambar dengan aspect ratio 4:3
- Card style dengan glass morphism effect
- Hover animations untuk gambar

## Fitur CSS Utama

### Section Container
- **Background:** Gradient `#f8f9fa` → `#e9ecef`
- **Pattern Overlay:** Subtle dot pattern untuk depth
- **Padding:** 80px vertical

### Grid Layout
- **Display:** CSS Grid dengan 2 kolom equal width
- **Gap:** 60px antara image dan content
- **Grid Template Areas:** Untuk alternating positioning

### Image Styling
- **Border Radius:** 20px untuk modern look
- **Shadow:** 0 20px 60px dengan opacity 0.15
- **Aspect Ratio:** 4:3 untuk consistency
- **Hover Effect:** Scale 1.05 dengan smooth transition

### Content Card
- **Background:** White dengan opacity 0.95 (glass effect)
- **Border Radius:** 20px
- **Backdrop Filter:** blur(10px) untuk frosted glass
- **Border:** 1px solid dengan warna brand (rgba)

### Typography
- **Title (h3):** 1.8rem, font-weight 700
- **Title Underline:** Gradient accent line 60px × 4px
- **Description:** 1.05rem dengan line-height 1.7
- **Color Scheme:** Dark gray untuk readability

## Gambar yang Digunakan

1. **Step 1 - Pilih Layanan**
   - URL: Beach destination image
   - Alt: "Pilih Layanan"

2. **Step 2 - Hubungi Admin**  
   - URL: Person using laptop
   - Alt: "Hubungi Admin"

3. **Step 3 - Lakukan Pembayaran**
   - URL: Payment/banking image
   - Alt: "Lakukan Pembayaran"

## Responsive Design

### Tablet (≤768px)
- Section padding dikurangi menjadi 50px
- Header font size: 2rem
- Grid menjadi 1 kolom (stacked)
- Kedua layout (left/right) menggunakan pattern: image → content
- Content padding: 25px
- Margin between steps: 50px

### Mobile (≤425px)
- Header font size: 1.75rem
- Content padding: 20px
- Title font size: 1.3rem
- Description font size: 0.9rem
- Underline accent: 50px × 3px
- Margin between steps: 40px

## Kelas CSS Baru

### Section & Layout
- `.booking-steps-alternating` - Main section container
- `.section-header-booking` - Header dengan center alignment
- `.booking-step-row` - Grid container untuk setiap step

### Components
- `.booking-step-image` - Image container dengan aspect ratio
- `.booking-step-content` - Content card dengan glass effect

### Positioning
- `.booking-step-left` - Image kiri, content kanan (Step 1, 3)
- `.booking-step-right` - Content kiri, image kanan (Step 2)

## Efek & Animasi

### Background Pattern
- Subtle dot pattern overlay dengan opacity 0.1
- Color: Brand color (#D4956E)

### Image Hover
```css
transform: scale(1.05);
transition: transform 0.6s ease;
```

### Title Underline
- Gradient dari #D4956E ke #F4A460
- Posisi absolute di bawah title
- Width: 60px, Height: 4px

### Card Styling
- Backdrop filter blur untuk glass morphism
- Box shadow dengan soft spread
- Border dengan brand color semi-transparent

## Kelebihan Desain Baru

1. **Visual Flow:** Alternating layout menciptakan Z-pattern reading flow
2. **Modern Look:** Glass morphism dan shadow effects
3. **Image Support:** Setiap step memiliki visual representation
4. **Better Engagement:** Gambar membuat konten lebih menarik
5. **Responsive:** Smooth transition ke layout vertikal di mobile
6. **Accessibility:** Clear hierarchy dan readable typography

## Testing Checklist

- [x] Desktop view (>768px) - Alternating layout bekerja
- [x] Tablet view (768px) - Stacked layout dengan image di atas
- [x] Mobile view (<425px) - Compact layout dengan spacing proporsional
- [x] Hover effects - Image zoom smooth dan natural
- [x] Glass morphism - Backdrop blur bekerja
- [x] Typography - Hierarchy jelas dan readable
- [x] No CSS errors
- [x] Cross-browser compatibility

## Catatan Tambahan

- Pattern overlay menggunakan inline SVG data URL
- Grid template areas memberikan fleksibilitas positioning
- Aspect ratio property untuk consistent image dimensions
- Glass morphism menggunakan backdrop-filter (modern browsers)
- Smooth transitions untuk professional feel

---

**Tanggal:** 6 Desember 2025  
**Status:** ✅ Selesai Diimplementasikan  
**Kompatibilitas:** Modern browsers (Chrome, Firefox, Safari, Edge)
