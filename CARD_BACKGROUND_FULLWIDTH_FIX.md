# 🎯 Card Background Full-Width Fix

## 📋 Problem Analysis

### 🔴 Masalah yang Ditemukan
Pada screenshot card Pelita Air, **background abu-abu di belakang logo tidak mengisi penuh** dari kiri ke kanan. Terlihat ada "potongan" atau ruang kosong di sisi kiri dan kanan, sehingga background tidak edge-to-edge dengan card.

### 🔍 Root Cause (Penyebab Utama)

```css
/* ❌ BEFORE - Penyebab background tidak full */
.company-logo-wrapper {
    width: 100%;                          /* ❌ 100% dari PARENT dengan padding */
    margin: -1rem -1rem 1rem -1rem;      /* ❌ Margin negatif tidak cukup */
    padding: var(--spacing-lg);           /* ❌ Ada padding internal */
}

.transport-card {
    padding: 1rem;                        /* ⚠️ Card punya padding 1rem */
}
```

**Kenapa tidak full?**
1. **Card punya padding 1rem** (kiri-kanan)
2. `.company-logo-wrapper` dengan `width: 100%` hanya mengisi **area dalam padding**
3. **Margin negatif -1rem** seharusnya keluar, TAPI tidak cukup karena:
   - Width masih 100% dari parent (yang sudah diperkecil padding)
   - Butuh width LEBIH LEBAR untuk benar-benar edge-to-edge

**Visual Diagram:**
```
┌────────────────────────────────────┐
│ Card (padding: 1rem kiri-kanan)   │
│  ┌──────────────────────────────┐ │
│  │ Logo Wrapper (width: 100%)   │ │ ⟵ TIDAK SAMPAI TEPI CARD
│  │ Background abu-abu           │ │
│  │ [LOGO IMAGE]                 │ │
│  └──────────────────────────────┘ │
└────────────────────────────────────┘
```

---

## ✅ Solution Implemented

### 🎨 CSS Final (Desktop)

```css
/* ✅ AFTER - Background FULL kiri-kanan */
.company-logo-wrapper {
    /* ✅ WIDTH CALCULATION: 100% + 2rem untuk menutupi padding card */
    width: calc(100% + 2rem);
    
    height: 160px;
    background: linear-gradient(135deg, #F4A460 0%, #D4956E 100%);
    border-radius: var(--radius-md) var(--radius-md) 0 0;
    
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    
    /* ✅ MARGIN NEGATIF: Keluar dari padding card */
    margin: -1rem -1rem 1rem -1rem;
    
    /* ✅ NO PADDING: Gambar mengisi penuh */
    padding: 0;
}

.company-logo {
    /* ✅ FULL WIDTH & HEIGHT */
    width: 100%;
    height: 160px;
    display: block;           /* ✅ Hilangkan spacing inline-element */

    /* ✅ OBJECT FIT CONTAIN - Proporsi terjaga */
    object-fit: contain;
    object-position: center;

    /* ✅ NO PADDING/MARGIN */
    padding: 0;
    margin: 0;

    transition: transform 0.3s ease;
}
```

### 📱 Responsive Breakpoints

**Tablet (max-width: 768px):**
```css
.company-logo-wrapper {
    width: calc(100% + 2rem);    /* ✅ FULL WIDTH */
    height: 140px;
    margin: -1rem -1rem 1rem -1rem;
    padding: 0;
}

.company-logo {
    width: 100%;
    height: 140px;
    display: block;
}
```

**Mobile (max-width: 425px):**
```css
.company-logo-wrapper {
    width: calc(100% + 2rem);    /* ✅ FULL WIDTH */
    height: 120px;
    margin: -1rem -1rem 0.75rem -1rem;
    padding: 0;
}

.company-logo {
    width: 100%;
    height: 120px;
    display: block;
}
```

---

## 🎯 Key Fixes Explained

### 1️⃣ Width Calculation
```css
width: calc(100% + 2rem);
```
- **100%**: Lebar parent (area dalam padding)
- **+ 2rem**: Tambahan untuk menutupi padding card kiri (1rem) + kanan (1rem)
- **Result**: Background keluar dari padding dan menyentuh tepi card

### 2️⃣ Negative Margin
```css
margin: -1rem -1rem 1rem -1rem;
/*       TOP   RIGHT  BOTTOM LEFT */
```
- **-1rem kiri/kanan**: Dorong wrapper keluar dari padding card
- **Combined with calc()**: Membuat background benar-benar edge-to-edge

### 3️⃣ Display Block
```css
display: block;
```
- **Hilangkan spacing** dari inline-element default `<img>`
- **Prevent whitespace** di bawah gambar

### 4️⃣ No Padding
```css
padding: 0;
margin: 0;
```
- **Zero padding**: Logo mengisi 100% area wrapper
- **Zero margin**: Tidak ada spacing tambahan

### 5️⃣ Object-fit Contain
```css
object-fit: contain;
object-position: center;
```
- **contain**: Seluruh logo terlihat tanpa cropping
- **center**: Logo di tengah secara horizontal & vertikal
- **No distortion**: Proporsi aspect ratio terjaga

---

## 📊 Before vs After Comparison

### ❌ BEFORE (Background Terpotong)
```
┌────────────────────────────────────┐
│ Card                               │
│  ┌──────────────────────────────┐ │  ⟵ Gap kiri
│  │ Background abu-abu           │ │
│  │ [LOGO]                       │ │
│  └──────────────────────────────┘ │  ⟵ Gap kanan
└────────────────────────────────────┘
    Terlihat terpotong, tidak rapi
```

### ✅ AFTER (Background Full-Width)
```
┌────────────────────────────────────┐
│┌──────────────────────────────────┐│  ⟵ Edge-to-edge
││ Background abu-abu (FULL)        ││
││ [LOGO CENTER]                    ││
│└──────────────────────────────────┘│
└────────────────────────────────────┘
    Background mengisi penuh, rapi!
```

---

## 🔧 Technical Breakdown

### Card Structure (HTML)
```html
<div class="transport-card">           <!-- Padding: 1rem -->
    <div class="company-logo-wrapper">  <!-- Width: calc(100% + 2rem) -->
        <img src="logo.png" class="company-logo">
    </div>
    <div class="transport-card-content">
        <h3>Pelita Air</h3>
        <p>Penerbangan charter dan regular</p>
        <p class="transport-price">Rp 380.000 - Rp 680.000</p>
        <button>Pesan Sekarang</button>
    </div>
</div>
```

### CSS Layer Stack
```
1. Card Container (padding: 1rem)
   └─ 2. Logo Wrapper (width: calc(100% + 2rem), margin: -1rem)
       └─ 3. Logo Image (width: 100%, object-fit: contain)
```

---

## ✅ Validation Checklist

- [x] Background mengisi penuh kiri-kanan (edge-to-edge)
- [x] Tidak ada gap/ruang kosong di sisi kiri dan kanan
- [x] Logo tetap center horizontal & vertikal
- [x] Logo tidak terdistorsi (proporsi terjaga)
- [x] Border-radius card tetap terlihat bagus
- [x] Responsive di semua breakpoint (desktop, tablet, mobile)
- [x] Hover effect tetap berfungsi normal

---

## 🎨 Applied to All Transport Types

Fix ini berlaku untuk:
- ✈️ **Pesawat** (Garuda Indonesia, Citilink, Sriwijaya Air, Pelita Air, dll)
- 🚢 **Kapal** (ASDP, Pelni, dll)
- 🚌 **Bus** (Various operators)

**Scope:**
- Global styling (`.company-logo-wrapper`, `.company-logo`)
- Page-specific (`.page-pemesanan .company-logo-wrapper`)
- All responsive breakpoints

---

## 📝 Summary

### ⚠️ Problem
Background abu-abu pada card maskapai tidak mengisi penuh kiri-kanan, terlihat terpotong.

### 🔍 Root Cause
- Card punya padding 1rem
- Logo wrapper width: 100% dari parent (yang sudah dikurangi padding)
- Margin negatif -1rem tidak cukup untuk full-width

### ✅ Solution
```css
width: calc(100% + 2rem);        /* Tambah 2rem untuk cover padding */
margin: -1rem -1rem 1rem -1rem;  /* Dorong keluar dari padding */
padding: 0;                       /* No internal padding */
```

### 🎯 Result
Background abu-abu sekarang **FULL WIDTH** dari kiri ke kanan, edge-to-edge dengan card, rapi dan profesional! ✨

---

## 🚀 Deployment Notes

**Files Modified:**
- `/srv/http/Website-Cendana/styles.css`

**Lines Changed:**
- Global `.company-logo-wrapper` (Line ~1845)
- Global `.company-logo` (Line ~1860)
- Responsive tablet (Line ~1991)
- Responsive mobile (Line ~2074)
- Page pemesanan `.page-pemesanan .company-logo-wrapper` (Line ~3210)
- Page pemesanan `.page-pemesanan .company-logo` (Line ~3242)
- Page pemesanan responsive tablet (Line ~3307)
- Page pemesanan responsive mobile (Line ~3320)

**Browser Compatibility:**
- ✅ Chrome/Edge/Opera (Chromium-based)
- ✅ Firefox
- ✅ Safari (iOS & macOS)
- ✅ Samsung Internet
- ⚠️ IE11 (calc() supported, but test recommended)

**Performance:**
- No performance impact
- CSS only changes
- No JavaScript modifications

---

**✨ Fix Complete!** Background abu-abu sekarang mengisi penuh dari kiri ke kanan. 🎉
