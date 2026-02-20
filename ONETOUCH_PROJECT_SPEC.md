# 📋 PANDUAN LENGKAP PENGEMBANGAN PROJECT ONE TOUCH
## Balai PPMHKP Lampung — Sistem Manajemen Sertifikat & Portal Layanan Digital

> **INSTRUKSI UNTUK AI AGENT:** Baca dokumen ini dari awal hingga akhir sebelum menulis satu baris kode pun. Setiap detail UI, nama file, warna, ukuran, posisi elemen, field form, dan logika sudah dituliskan secara eksplisit. Ikuti dengan tepat.

---

## ⚙️ ENVIRONMENT AKTUAL (WAJIB DIIKUTI)

| Komponen | Versi Aktual |
|----------|-------------|
| **Laravel** | **10.50.2** |
| **PHP** | **8.1.x** |
| **MySQL** | **8.0** |
| **Server** | Laragon (Apache) |
| **Project Path** | `C:\laragon\www\OneTouch` |
| **URL Lokal** | `http://OneTouch.test` |
| **OS Dev** | Windows |

> ⚠️ **PENTING:** Project sudah dibuat dengan `laravel/laravel v10.3.3` yang menginstall `laravel/framework 10.50.2`. JANGAN menggunakan syntax Laravel 11. Middleware didaftarkan di `app/Http/Kernel.php`, BUKAN `bootstrap/app.php`.

---

## 🗂️ DAFTAR ISI
1. [Stack Teknologi](#1-stack-teknologi)
2. [Struktur Folder Laravel](#2-struktur-folder-laravel)
3. [Database Schema](#3-database-schema)
4. [Design System & Variabel CSS Global](#4-design-system--variabel-css-global)
5. [Assets & File Logo](#5-assets--file-logo)
6. [Sistem Autentikasi & Role](#6-sistem-autentikasi--role)
7. [BAGIAN A: Portal Publik](#7-bagian-a-portal-publik)
8. [BAGIAN B: Sistem Internal (Login Required)](#8-bagian-b-sistem-internal-login-required)
9. [Komponen UI Reusable](#9-komponen-ui-reusable)
10. [Responsivitas & Breakpoints](#10-responsivitas--breakpoints)
11. [Panduan Migrasi & Seeder Database](#11-panduan-migrasi--seeder-database)
12. [Urutan Pengerjaan yang Disarankan](#12-urutan-pengerjaan-yang-disarankan)

---

## 1. STACK TEKNOLOGI

### Backend
- **Framework:** Laravel **10.50.2** (laravel/framework ^10.0)
- **PHP:** **8.1.x** (minimum, tidak support PHP 8.2+ features)
- **Database:** MySQL **8.0**
- **ORM:** Eloquent
- **Auth:** Manual session auth (JANGAN install Breeze — buat LoginController sendiri)
- **Role Permission:** `spatie/laravel-permission` **^5.10** (versi kompatibel Laravel 10 + PHP 8.1)
  - Install: `composer require spatie/laravel-permission:^5.10`
- **PDF Export:** `barryvdh/laravel-dompdf` **^2.0**
  - Install: `composer require barryvdh/laravel-dompdf:^2.0`
- **Excel Export:** `maatwebsite/excel` **^3.1**
  - Install: `composer require maatwebsite/excel:^3.1`
- **File Upload:** Laravel Storage (disk: `public`) — jalankan `php artisan storage:link`
- **Scheduler:** Laravel Task Scheduler di `app/Console/Kernel.php`

### Frontend
- **Template Engine:** Laravel Blade
- **CSS:** Pure CSS custom (variabel CSS, tidak pakai Tailwind/Bootstrap)
- **Icons:** Font Awesome 6.4.0 via CDN:
  `https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css`
- **Charts:** Chart.js via CDN:
  `https://cdn.jsdelivr.net/npm/chart.js`
- **Font:** Inter dari Google Fonts:
  `https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap`
- **JavaScript:** Vanilla JS murni (tidak perlu Vue/React/Alpine)

### Server (Laragon)
- Apache (sudah include di Laragon)
- PHP 8.1 (sudah aktif di Laragon)
- MySQL 8.0 (sudah include di Laragon)
- Pretty URL sudah aktif: `http://OneTouch.test`

### Urutan Install Package (jalankan dari `C:\laragon\www\OneTouch`):
```bash
composer require spatie/laravel-permission:^5.10
composer require barryvdh/laravel-dompdf:^2.0
composer require maatwebsite/excel:^3.1
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
php artisan storage:link
```

---

## 2. STRUKTUR FOLDER LARAVEL

> **Catatan:** Ini adalah struktur tambahan di atas folder Laravel 10 yang sudah ada. Folder `app/`, `routes/`, `resources/`, `database/` sudah ada — tambahkan file-file baru sesuai struktur di bawah.

```
C:\laragon\www\OneTouch\
├── app/
│   ├── Console/
│   │   └── Kernel.php                     ← Tambahkan scheduler di sini (Laravel 10)
│   ├── Http/
│   │   ├── Kernel.php                     ← Daftarkan middleware di sini (Laravel 10)
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php
│   │   │   ├── PublicSite/                ← Namespace: App\Http\Controllers\PublicSite
│   │   │   │   ├── HomeController.php
│   │   │   │   ├── LayananController.php
│   │   │   │   ├── SkmController.php
│   │   │   │   ├── EksporController.php
│   │   │   │   ├── MediaController.php
│   │   │   │   ├── AplikasiController.php
│   │   │   │   ├── RegulasiController.php
│   │   │   │   └── AboutController.php
│   │   │   ├── Admin/                     ← Namespace: App\Http\Controllers\Admin
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── SertifikatController.php
│   │   │   │   ├── InspeksiController.php
│   │   │   │   ├── UserController.php
│   │   │   │   └── LaporanController.php
│   │   │   ├── Petugas/                   ← Namespace: App\Http\Controllers\Petugas
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── SertifikatController.php
│   │   │   │   ├── InspeksiController.php
│   │   │   │   └── LaporanController.php
│   │   │   └── User/                      ← Namespace: App\Http\Controllers\User
│   │   │       ├── DashboardController.php
│   │   │       ├── SertifikatController.php
│   │   │       ├── InspeksiController.php
│   │   │       └── LaporanController.php
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php           ← Sudah ada di Laravel 10
│   │   │   └── RoleMiddleware.php         ← BUAT BARU: cek role user
│   │   └── Requests/                      ← Form Request Validation
│   │       ├── StoreSertifikatRequest.php
│   │       └── StoreInspeksiRequest.php
│   └── Models/
│       ├── User.php                       ← Edit: tambahkan HasRoles dari Spatie
│       ├── Sertifikat.php                 ← BUAT BARU
│       ├── Inspeksi.php                   ← BUAT BARU
│       ├── DataEkspor.php                 ← BUAT BARU
│       └── DataSkm.php                    ← BUAT BARU
├── database/
│   ├── migrations/
│   │   ├── [timestamp]_create_sertifikats_table.php
│   │   ├── [timestamp]_create_inspeksis_table.php
│   │   ├── [timestamp]_create_data_skms_table.php
│   │   └── [timestamp]_create_data_ekspors_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php             ← Edit: panggil semua seeder
│       ├── UserSeeder.php
│       ├── SertifikatSeeder.php
│       ├── InspeksiSeeder.php
│       ├── DataSkmSeeder.php
│       └── DataEksporSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── public.blade.php           ← Layout portal publik (navbar + footer)
│       │   └── internal.blade.php         ← Layout sistem manajemen (sidebar + topbar)
│       ├── auth/
│       │   └── login.blade.php
│       ├── public/
│       │   ├── home.blade.php
│       │   ├── layanan.blade.php
│       │   ├── skm.blade.php
│       │   ├── ekspor.blade.php
│       │   ├── media.blade.php
│       │   ├── aplikasi.blade.php
│       │   ├── regulasi.blade.php
│       │   └── about.blade.php
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── sertifikat/
│       │   │   └── index.blade.php        ← Tabel + modal add/edit/delete
│       │   ├── inspeksi/
│       │   │   └── index.blade.php
│       │   ├── users/
│       │   │   └── index.blade.php
│       │   └── laporan/
│       │       └── index.blade.php
│       ├── petugas/
│       │   ├── dashboard.blade.php
│       │   ├── sertifikat/index.blade.php
│       │   ├── inspeksi/index.blade.php
│       │   └── laporan/index.blade.php
│       ├── user/
│       │   ├── dashboard.blade.php
│       │   ├── sertifikat/index.blade.php
│       │   ├── inspeksi/index.blade.php
│       │   └── laporan/index.blade.php
│       └── pdf/
│           └── laporan.blade.php          ← Template PDF untuk dompdf
├── public/
│   └── assets/
│       ├── images/
│       │   ├── header-logo1-kkp.png
│       │   ├── header-logo2-bppmhkp.png
│       │   ├── bg-light.jpg
│       │   └── bg-dark.jpg
│       └── uploads/                       ← Gunakan storage:link, bukan folder ini
├── storage/
│   └── app/
│       └── public/
│           └── berkas/                    ← File upload berkas inspeksi disimpan di sini
│                                             (diakses via /storage/berkas/namafile)
└── routes/
    └── web.php                            ← Semua route ada di sini
```

---

## 3. DATABASE SCHEMA

### Tabel: `users`
```sql
CREATE TABLE users (
  id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name            VARCHAR(255) NOT NULL,           -- Nama lengkap
  username        VARCHAR(100) UNIQUE NOT NULL,    -- Username login
  password        VARCHAR(255) NOT NULL,
  role            ENUM('admin','petugas','user') NOT NULL DEFAULT 'user',
  company_name    VARCHAR(255) NULL,               -- Nama perusahaan (untuk role user)
  remember_token  VARCHAR(100) NULL,
  created_at      TIMESTAMP NULL,
  updated_at      TIMESTAMP NULL
);
```

### Tabel: `sertifikats`
```sql
CREATE TABLE sertifikats (
  id                BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id           BIGINT UNSIGNED NOT NULL,          -- FK ke users (pemilik)
  nama_pemilik      VARCHAR(255) NOT NULL,             -- Nama perusahaan/kapal
  nomor_sertifikat  VARCHAR(100) NOT NULL,             -- Contoh: 530/HACCP/2023
  ruang_lingkup     VARCHAR(255) NOT NULL,             -- Contoh: Pengolahan Ikan
  jenis_sertifikat  ENUM('HACCP','SKP','SPDI','CPIB','CBIB') NOT NULL,
  grade             ENUM('A','B','C') NOT NULL DEFAULT 'A',
  tanggal_terbit    DATE NOT NULL,
  tanggal_kadaluwarsa DATE NOT NULL,
  status_masa       ENUM('aktif','warning','expired') NOT NULL DEFAULT 'aktif',
  status_proses     ENUM('Pending','Process','Completed') NOT NULL DEFAULT 'Pending',
  created_at        TIMESTAMP NULL,
  updated_at        TIMESTAMP NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Tabel: `inspeksis`
```sql
CREATE TABLE inspeksis (
  id                BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id           BIGINT UNSIGNED NOT NULL,          -- FK ke users (pemilik)
  nama_perusahaan   VARCHAR(255) NOT NULL,
  tanggal           DATE NOT NULL,
  kategori          ENUM('Inspeksi','Surveilan') NOT NULL,
  jenis_sertifikat  ENUM('HACCP','SKP','SPDI','CPIB','CBIB') NOT NULL,
  berkas_path       VARCHAR(500) NULL,                 -- Path file upload (PDF/DOCX)
  status_berkas     ENUM('Terkirim','Tidak Ada') NOT NULL DEFAULT 'Tidak Ada',
  created_at        TIMESTAMP NULL,
  updated_at        TIMESTAMP NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Tabel: `data_skms`
```sql
CREATE TABLE data_skms (
  id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tahun       YEAR NOT NULL,
  target      DECIMAL(5,2) NOT NULL,    -- Persentase target (misal: 80.00)
  realisasi   DECIMAL(5,2) NOT NULL,    -- Persentase realisasi (misal: 85.50)
  created_at  TIMESTAMP NULL,
  updated_at  TIMESTAMP NULL
);
```

### Tabel: `data_ekspors`
```sql
CREATE TABLE data_ekspors (
  id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  bulan           TINYINT NOT NULL,        -- 1-12
  tahun           YEAR NOT NULL,
  frekuensi       INT NOT NULL,            -- Jumlah pengiriman
  volume          DECIMAL(12,2) NOT NULL,  -- Dalam Ton
  nilai           DECIMAL(15,2) NOT NULL,  -- Dalam USD
  created_at      TIMESTAMP NULL,
  updated_at      TIMESTAMP NULL
);
```

---

## 4. DESIGN SYSTEM & VARIABEL CSS GLOBAL

**Letakkan variabel CSS ini di semua layout blade, baik publik maupun internal:**

```css
:root {
  /* Warna Utama */
  --primary:       #0f172a;   /* Navy gelap - warna dominan */
  --primary-light: #1e293b;   /* Navy sedang */
  --primary-dark:  #0a0e1a;   /* Navy paling gelap */
  --accent:        #d4af37;   /* Emas - aksen brand */
  --accent-hover:  #b5952f;   /* Emas hover */

  /* Status */
  --success: #10b981;   /* Hijau */
  --warning: #f59e0b;   /* Kuning/oranye */
  --danger:  #ef4444;   /* Merah */
  --info:    #3b82f6;   /* Biru */

  /* Light Mode */
  --bg-body:     #f1f5f9;   /* Background halaman */
  --bg-surface:  #ffffff;   /* Background card/sidebar */
  --text-main:   #1e293b;   /* Teks utama */
  --text-muted:  #64748b;   /* Teks sekunder */
  --border-color:#e2e8f0;   /* Border */

  /* Dark Mode */
  --bg-dark:         #1a1f2e;   /* Background gelap */
  --bg-dark-surface: #252d3d;   /* Card gelap */
  --text-dark:       #e2e8f0;   /* Teks mode gelap */

  /* Dimensi */
  --sidebar-width: 260px;
  --radius-md: 8px;
  --radius-lg: 12px;

  /* Shadow */
  --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
  --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
  --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);

  /* Transisi */
  --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Inter', sans-serif;
}

body {
  background-color: var(--bg-body);
  color: var(--text-main);
  font-size: 0.925rem;
  line-height: 1.5;
  overflow-x: hidden;
  transition: var(--transition);
}

body.dark-mode {
  background-color: var(--bg-dark);
  color: var(--text-dark);
}
```

### Badge CSS (dipakai di tabel-tabel):
```css
.badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 600;
}
.badge-aktif, .badge-active     { background: #dcfce7; color: #15803d; }
.badge-warning, .badge-soon     { background: #fef3c7; color: #b45309; }
.badge-expired, .badge-kadaluwarsa { background: #fee2e2; color: #991b1b; }
.badge-pending                  { background: #dbeafe; color: #1e40af; }
.badge-process                  { background: #e0e7ff; color: #312e81; }
.badge-completed, .badge-selesai { background: #d1fae5; color: #065f46; }
.badge-admin                    { background: #ddd6fe; color: #5b21b6; }
.badge-officer, .badge-petugas  { background: #c7d2fe; color: #3730a3; }
.badge-user                     { background: #e0e7ff; color: #3730a3; }
.badge-terkirim                 { background: #d1fae5; color: #065f46; }
.badge-tidak-ada                { background: #fee2e2; color: #991b1b; }
.badge-inspeksi                 { background: #f1f5f9; color: #475569; }
.badge-surveilan                { background: #f0fdf4; color: #166534; }
```

---

## 5. ASSETS & FILE LOGO

### ⚠️ Lokasi Folder Asset Saat Ini

Asset saat ini berada di:
```
C:\laragon\www\OneTouch\assets\     ← SALAH, tidak bisa diakses browser
```

**Harus dipindahkan ke:**
```
C:\laragon\www\OneTouch\public\assets\
```

Laragon serving dari folder `public/` sebagai web root. File di luar `public/` tidak bisa diakses browser. Jalankan perintah ini sekali untuk memindahkan:
```
xcopy C:\laragon\www\OneTouch\assets C:\laragon\www\OneTouch\public\assets /E /I /Y
```
Setelah itu akses logo via Blade: `{{ asset('assets/nama-file.png') }}`

---

### Daftar Lengkap File Asset

| File | Keterangan | Gunakan Di |
|------|-----------|------------|
| `header-logo1-kkp.png` | Logo KKP horizontal, teks hitam | Navbar publik (kiri), Sidebar internal, Header kartu login |
| `header-logo2-bppmhkp.png` | Logo BPPMHKP Lampung | Navbar publik (kanan), Sidebar internal, Header kartu login |
| `bg-light.jpg` | Foto/gambar background terang | Background hero section portal publik — **mode terang** |
| `bg-dark.jpg` | Foto/gambar background gelap | Background hero section portal publik — **mode gelap** |
| `Portal-Logo-KKP-TeksHitam.png` | Logo KKP portal, teks hitam | Footer portal publik (background putih) |
| `Portal-LogoKKP-TeksPutih.png` | Logo KKP portal, teks putih | Footer portal publik (background navy gelap) |
| `Portal-LogoKKPRound-TeksPutih.png` | Logo KKP bulat, teks putih | Ikon/favicon, header gelap |
| `Portal-LogoKKPRound-Warna.png` | Logo KKP bulat, berwarna | About us, halaman profil |

---

### Panduan Penggunaan Logo Per Halaman

**Halaman Login** (`auth/login.blade.php`):
```html
<!-- Dua logo sejajar, di atas form -->
<div style="display:flex; align-items:center; justify-content:center; gap:12px; margin-bottom:1.5rem;">
    <img src="{{ asset('assets/header-logo1-kkp.png') }}" height="48" alt="Logo KKP">
    <div style="border-right:1px solid #e2e8f0; height:40px;"></div>
    <img src="{{ asset('assets/header-logo2-bppmhkp.png') }}" height="48" alt="Logo BPPMHKP">
</div>
```

**Navbar Portal Publik** (`layouts/public.blade.php`):
```html
<!-- Pojok kiri navbar -->
<div style="display:flex; align-items:center; gap:10px;">
    <img src="{{ asset('assets/header-logo1-kkp.png') }}" height="40" alt="KKP">
    <div style="border-right:1.5px solid #e2e8f0; height:36px;"></div>
    <img src="{{ asset('assets/header-logo2-bppmhkp.png') }}" height="40" alt="BPPMHKP">
    <span style="font-weight:600; font-size:0.9rem; margin-left:8px;">Balai PPMHKP Lampung</span>
</div>
```

**Sidebar Internal** (`layouts/internal.blade.php`):
```html
<!-- Sidebar header -->
<div class="sidebar-header">
    <div style="display:flex; align-items:center; gap:8px;">
        <i class="fa-solid fa-anchor" style="color:var(--accent); font-size:1.2rem;"></i>
        <span style="font-weight:700; font-size:1.1rem;">
            ONE<span style="color:var(--accent);">TOUCH</span>
        </span>
    </div>
    <!-- Logo kecil di bawah teks (opsional, jika ada ruang) -->
    <div style="display:flex; gap:6px; margin-top:6px;">
        <img src="{{ asset('assets/header-logo1-kkp.png') }}" height="24" alt="KKP">
        <img src="{{ asset('assets/header-logo2-bppmhkp.png') }}" height="24" alt="BPPMHKP">
    </div>
</div>
```

**Footer Portal Publik** (`layouts/public.blade.php`):
```html
<!-- Background footer adalah navy gelap #0f172a, pakai versi teks putih -->
<img src="{{ asset('assets/Portal-LogoKKP-TeksPutih.png') }}" height="48" alt="KKP">
```

**Hero Section Background** (CSS di `layouts/public.blade.php`):
```css
/* Light mode */
.hero-section {
    background-image: url("{{ asset('assets/bg-light.jpg') }}");
    background-size: cover;
    background-position: center;
}
/* Dark mode */
body.dark-mode .hero-section {
    background-image: url("{{ asset('assets/bg-dark.jpg') }}");
}
```
> ⚠️ Karena Blade tidak bisa dipakai langsung di `<style>`, gunakan inline style atau pass URL via variable PHP ke JavaScript.

### Cara Akses Asset di Blade

Selalu gunakan helper `asset()` agar URL selalu benar di semua environment:
```php
{{ asset('assets/header-logo1-kkp.png') }}
// Menghasilkan: http://OneTouch.test/assets/header-logo1-kkp.png

{{ asset('assets/bg-light.jpg') }}
// Menghasilkan: http://OneTouch.test/assets/bg-light.jpg
```

Untuk background image di CSS inline:
```html
<div style="background-image: url('{{ asset('assets/bg-light.jpg') }}'); background-size:cover;">
```

---

## 6. SISTEM AUTENTIKASI & ROLE

### Login Screen
**URL:** `/login`

**Tampilan halaman login:**
- Background penuh: gradient linear dari `#0f172a` ke `#1e3a8a` (navy ke biru gelap), arah 135deg
- Di atas background ada efek blur/lingkaran besar semi-transparan untuk estetika
- Kartu login berada di tengah layar (flex, align-center, justify-center)
- Kartu login: `background: rgba(255,255,255,0.95)`, `backdrop-filter: blur(10px)`, border-radius: 12px, max-width: 400px, padding: 2.5rem, box-shadow besar, border-top: 4px solid var(--accent) (garis emas di atas kartu)

**Isi kartu login dari atas ke bawah:**
1. **Brand logo area** (text-align: center, margin-bottom: 2rem):
   - Icon jangkar Font Awesome (`fa-anchor`): font-size: 2rem, warna: var(--accent)
   - Dua logo gambar (KKP dan BPPMHKP) sejajar, height: 48px masing-masing, gap: 12px, align: center
   - Garis pemisah vertikal di antara logo: `border-right: 1px solid #e2e8f0; height: 40px;`
   - Teks `ONE TOUCH` (font-size: 1.5rem, font-weight: 800, color: var(--primary))
   - Teks `Manajemen Sertifikat & Arsip Digital` (font-size: 0.8rem, color: var(--text-muted))
   - Teks `Balai PPMHKP Lampung` (font-size: 0.8rem, color: var(--text-muted), font-weight: 500)

2. **Error message div** (hidden by default, tampil merah jika login gagal):
   - `background: #fee2e2; color: var(--danger); padding: 0.75rem; border-radius: 8px;`

3. **Form input:**
   - Label: `Username` (font-size: 0.85rem, font-weight: 500, color: var(--text-muted))
   - Input username: `type="text"`, placeholder: `masukkan username`
   - Label: `Password`
   - Input password: `type="password"`, placeholder: `masukkan password`
   - **Dropdown "Login Sebagai" (Simulasi/Dev mode):** `<select>` dengan opsi: `Admin (Full Akses)`, `Petugas (Input Data)`, `User Biasa (Hanya Lihat)` — dropdown ini untuk mode pengembangan, di production bisa disembunyikan
   - Tombol submit: lebar penuh, `background: var(--accent)`, warna teks putih, teks: `Login`, icon `fa-sign-in-alt` di sebelah kiri teks, height: 44px

4. **Footer kartu:** teks `Versi 1.0.0 © 2024` (font-size: 0.75rem, text-align: center, color: var(--text-muted), margin-top: 1.5rem)

### Logika Role Setelah Login

| Role | Redirect Setelah Login |
|------|----------------------|
| `admin` | `/admin/dashboard` |
| `petugas` | `/petugas/dashboard` |
| `user` | `/user/dashboard` |

### Route Groups (Laravel 10 — `routes/web.php`)

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PublicSite\HomeController;
use App\Http\Controllers\PublicSite\LayananController;
use App\Http\Controllers\PublicSite\SkmController;
use App\Http\Controllers\PublicSite\EksporController;
use App\Http\Controllers\PublicSite\MediaController;
use App\Http\Controllers\PublicSite\AplikasiController;
use App\Http\Controllers\PublicSite\RegulasiController;
use App\Http\Controllers\PublicSite\AboutController;

// ─── Portal Publik (tanpa auth) ───────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
Route::get('/skm', [SkmController::class, 'index'])->name('skm');
Route::get('/ekspor', [EksporController::class, 'index'])->name('ekspor');
Route::get('/media', [MediaController::class, 'index'])->name('media');
Route::get('/aplikasi', [AplikasiController::class, 'index'])->name('aplikasi');
Route::get('/regulasi', [RegulasiController::class, 'index'])->name('regulasi');
Route::get('/tentang', [AboutController::class, 'index'])->name('about');

// ─── Auth ──────────────────────────────────────────────────────
Route::get('/login', [LoginController::class, 'showForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ─── Admin ────────────────────────────────────────────────────
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/sertifikat', \App\Http\Controllers\Admin\SertifikatController::class);
        Route::resource('/inspeksi', \App\Http\Controllers\Admin\InspeksiController::class);
        Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);
        Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('/laporan/excel', [\App\Http\Controllers\Admin\LaporanController::class, 'exportExcel'])->name('laporan.excel');
    });

// ─── Petugas ──────────────────────────────────────────────────
Route::prefix('petugas')
    ->middleware(['auth', 'role:petugas'])
    ->name('petugas.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Petugas\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/sertifikat', \App\Http\Controllers\Petugas\SertifikatController::class);
        Route::resource('/inspeksi', \App\Http\Controllers\Petugas\InspeksiController::class);
        Route::get('/laporan', [\App\Http\Controllers\Petugas\LaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/pdf', [\App\Http\Controllers\Petugas\LaporanController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('/laporan/excel', [\App\Http\Controllers\Petugas\LaporanController::class, 'exportExcel'])->name('laporan.excel');
    });

// ─── User ─────────────────────────────────────────────────────
Route::prefix('user')
    ->middleware(['auth', 'role:user'])
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/sertifikat', [\App\Http\Controllers\User\SertifikatController::class, 'index'])->name('sertifikat');
        Route::get('/inspeksi', [\App\Http\Controllers\User\InspeksiController::class, 'index'])->name('inspeksi');
        Route::get('/laporan', [\App\Http\Controllers\User\LaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/pdf', [\App\Http\Controllers\User\LaporanController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('/laporan/excel', [\App\Http\Controllers\User\LaporanController::class, 'exportExcel'])->name('laporan.excel');
        Route::get('/inspeksi/{id}/download', [\App\Http\Controllers\User\InspeksiController::class, 'download'])->name('inspeksi.download');
    });
```

### Middleware Registration (Laravel 10 — `app/Http/Kernel.php`)

Tambahkan di dalam array `$routeMiddleware` (atau `$middlewareAliases` di Laravel 10.x terbaru):

```php
// Di dalam class Kernel extends HttpKernel
protected $middlewareAliases = [
    // ... middleware yang sudah ada ...
    'auth'       => \App\Http\Middleware\Authenticate::class,
    'guest'      => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'role'       => \App\Http\Middleware\RoleMiddleware::class,  // ← TAMBAHKAN INI
];
```

### RoleMiddleware (`app/Http/Middleware/RoleMiddleware.php`)

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== $role) {
            // Redirect ke dashboard sesuai role masing-masing
            $redirectMap = [
                'admin'   => '/admin/dashboard',
                'petugas' => '/petugas/dashboard',
                'user'    => '/user/dashboard',
            ];
            $userRole = auth()->user()->role;
            return redirect($redirectMap[$userRole] ?? '/');
        }

        return $next($request);
    }
}
```

### LoginController (`app/Http/Controllers/Auth/LoginController.php`)

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $role = Auth::user()->role;
            return match($role) {
                'admin'   => redirect()->intended('/admin/dashboard'),
                'petugas' => redirect()->intended('/petugas/dashboard'),
                'user'    => redirect()->intended('/user/dashboard'),
                default   => redirect('/'),
            };
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
```

### User Model Update (`app/Models/User.php`)

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'company_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',  // Laravel 10 sudah support ini
    ];

    // Relasi
    public function sertifikats()
    {
        return $this->hasMany(Sertifikat::class);
    }

    public function inspeksis()
    {
        return $this->hasMany(Inspeksi::class);
    }
}
```

> ⚠️ **CATATAN:** Kita TIDAK menggunakan Spatie HasRoles di sini. Role disimpan langsung di kolom `role` pada tabel `users` dengan nilai ENUM `'admin'`, `'petugas'`, `'user'`. Ini lebih sederhana dan cukup untuk project ini. Package `spatie/laravel-permission` hanya diinstall jika diperlukan di masa depan.

---

## 7. BAGIAN A: PORTAL PUBLIK

### Layout Publik (`layouts/public.blade.php`)

**Struktur HTML keseluruhan:**
```
<html>
  <head>
    [meta, Google Fonts Inter, Font Awesome CDN, Chart.js CDN, CSS variables]
    [Dark mode toggle script: localStorage key = 'onetouchTheme']
  </head>
  <body class="{{ session('theme') == 'dark' ? 'dark-mode' : '' }}">
    <nav>   ← Navbar sticky di atas
    <main>  ← @yield('content')
    <footer>
    [JS script dark mode toggle global]
  </body>
```

### Navbar Portal Publik

**Tampilan:**
- Background: `var(--bg-surface)` (putih di light, #252d3d di dark)
- `position: sticky; top: 0; z-index: 100;`
- `border-bottom: 1px solid var(--border-color);`
- Height: 64px
- Padding horizontal: 2rem (desktop), 1rem (mobile)
- `display: flex; align-items: center; justify-content: space-between;`

**Sisi KIRI navbar (logo area):**
- Logo KKP: `<img src="/assets/images/header-logo1-kkp.png" height="40px">`
- Garis pemisah vertikal: `border-right: 1.5px solid #e2e8f0; height: 36px; margin: 0 12px;`
- Logo BPPMHKP: `<img src="/assets/images/header-logo2-bppmhkp.png" height="40px">`
- Teks nama: `Balai PPMHKP Lampung` font-weight: 600, font-size: 0.95rem, color: var(--text-main), margin-left: 10px
- (Di mobile < 768px: teks nama disembunyikan)

**Tengah navbar (menu navigasi — desktop):**
- Menu link: `Beranda` | `Layanan` | `SKM` | `Ekspor` | `Media` | `Aplikasi` | `Regulasi` | `Tentang Kami`
- Setiap link: font-size: 0.875rem, font-weight: 500, color: var(--text-muted), padding: 0.5rem 0.75rem
- Link aktif: color: var(--primary), font-weight: 600, border-bottom: 2px solid var(--accent)
- Hover: color: var(--primary)

**Sisi KANAN navbar:**
- Tombol dark mode toggle: ikon matahari (`fa-sun`) di light mode, ikon bulan (`fa-moon`) di dark mode. Style: background: #f8fafc, border: 1px solid var(--border-color), border-radius: 8px, padding: 0.5rem 0.75rem
- Tombol `Login`: background: var(--primary), color: white, border-radius: 8px, padding: 0.5rem 1rem, font-weight: 500, link ke `/login`
- (Di mobile: menu navigasi disembunyikan, diganti hamburger icon `fa-bars`)

**Mobile Navbar:**
- Hamburger button (`fa-bars`) di kanan
- Saat diklik: slide-down menu tampil di bawah navbar, berisi semua link vertikal
- Menu mobile: background putih, setiap item padding 1rem 1.5rem, border-bottom tipis

---

### HALAMAN 1: BERANDA / HOME (`/`)

**URL:** `/`
**Blade File:** `resources/views/public/home.blade.php`

---

#### Section 1: Hero / Banner

**Tampilan:**
- Full-width, min-height: 500px (desktop), min-height: 350px (mobile)
- Background: gambar `bg-light.jpg` (saat light mode) atau `bg-dark.jpg` (saat dark mode) sebagai background-image, cover, center
- Di atas gambar: overlay gelap `rgba(15, 23, 42, 0.65)` agar teks terbaca
- Konten hero di tengah (text-align: center, flex, align-center, justify-center, flex-direction: column)

**Isi konten hero dari atas ke bawah:**
1. Badge kecil: background: rgba(212,175,55,0.2), border: 1px solid var(--accent), color: var(--accent), border-radius: 9999px, padding: 0.35rem 1rem, font-size: 0.8rem, teks: `🏛️ Balai PPMHKP Lampung`
2. Judul utama: `ONE TOUCH` — font-size: 3.5rem (desktop), 2rem (mobile), font-weight: 900, color: white, letter-spacing: -1px
3. Sub judul: `Portal Layanan Digital Terpadu` — font-size: 1.25rem (desktop), 1rem (mobile), color: rgba(255,255,255,0.85), margin-top: 0.5rem
4. Deskripsi singkat: `Satu pintu akses untuk semua layanan, informasi, dan sistem digital Balai PPMHKP Lampung.` — font-size: 0.95rem, color: rgba(255,255,255,0.7), max-width: 550px, margin: 1rem auto
5. Dua tombol CTA sejajar (gap: 1rem, flex-wrap: wrap, justify: center):
   - Tombol 1: `Mulai Layanan →` — background: var(--accent), color: #0f172a, font-weight: 700, padding: 0.85rem 2rem, border-radius: 8px, link ke `/layanan`
   - Tombol 2: `Sampaikan Aspirasi` — background: transparent, border: 2px solid rgba(255,255,255,0.6), color: white, padding: 0.85rem 2rem, border-radius: 8px, link ke `/aplikasi` (bagian pengaduan)
   - Hover keduanya: transform: translateY(-2px), box-shadow

---

#### Section 2: Statistik Singkat (Counter Cards)

**Tampilan:**
- Background: var(--bg-surface)
- Padding: 3rem 2rem
- 4 kartu sejajar (grid: repeat(4, 1fr) di desktop, repeat(2, 1fr) di tablet, 1 kolom di mobile)

**4 Kartu Statistik:**
1. **Total Sertifikat Aktif** — ikon: `fa-certificate` (warna emas), angka besar, sub: `Sertifikat terverifikasi`
2. **Unit Kerja Terlayani** — ikon: `fa-building` (warna biru), angka besar, sub: `Perusahaan & kapal`
3. **Inspeksi Dilakukan** — ikon: `fa-clipboard-check` (warna hijau), angka besar, sub: `Tahun ini`
4. **Tahun Beroperasi** — ikon: `fa-calendar-check` (warna ungu), angka besar, sub: `Melayani Indonesia`

**Style kartu:** background: var(--bg-surface), border: 1px solid var(--border-color), border-radius: 12px, padding: 1.5rem, text-align: center, box-shadow: var(--shadow-sm), hover: transform translateY(-4px)

---

#### Section 3: Akses Cepat — Link Layanan (Quick Links)

**Tampilan:**
- Background: var(--bg-body)
- Padding: 3rem 2rem
- Judul section: `Akses Cepat Layanan` (font-size: 1.5rem, font-weight: 700, text-align: center, margin-bottom: 0.5rem)
- Sub judul: `Akses langsung sistem layanan digital KKP` (font-size: 0.9rem, color: var(--text-muted), text-align: center, margin-bottom: 2rem)
- Grid 4 kolom (desktop), 2 kolom (tablet), 1 kolom (mobile)

**4 Kartu Akses Cepat (link ke eksternal):**

1. **SIAPMutu**
   - Icon: `fa-award` warna biru
   - Judul: `SIAPMutu`
   - Deskripsi: `Sertifikasi Mutu Hasil Kelautan dan Perikanan untuk tujuan ekspor`
   - Tombol: `Akses Sekarang →` link ke `https://siapmutu.kkp.go.id/login` (target: _blank)

2. **HONEST**
   - Icon: `fa-shield-check` warna hijau
   - Judul: `HONEST`
   - Deskripsi: `HACCP Online System — Sistem jaminan keamanan pangan`
   - Tombol: `Akses Sekarang →` link ke `https://haccp.kkp.go.id/h4/login/` (target: _blank)

3. **SKP Online**
   - Icon: `fa-file-certificate` warna oranye
   - Judul: `SKP`
   - Deskripsi: `Penerbitan Sertifikat Kelayakan Pengolahan`
   - Tombol: `Akses Sekarang →` link ke `https://skp-pdspkp.kkp.go.id/skp-online/auth/login` (target: _blank)

4. **OSS**
   - Icon: `fa-globe` warna ungu
   - Judul: `OSS`
   - Deskripsi: `Penerbitan Sertifikat CBIB, CPIB, CPIB Kapal`
   - Tombol: `Akses Sekarang →` link ke `https://oss.go.id/i` (target: _blank)

**Style kartu quick links:** background: var(--bg-surface), border: 1px solid var(--border-color), border-radius: 12px, padding: 1.5rem, box-shadow: var(--shadow-sm). Icon dibungkus div bulat berukuran 48x48px, warna bg sesuai ikon. Hover: transform translateY(-4px), box-shadow lebih besar

---

#### Section 4: Foto Kegiatan (Slider/Carousel)

**Tampilan:**
- Background: var(--bg-surface)
- Padding: 3rem 2rem
- Judul: `Dokumentasi Kegiatan` (text-align: center)
- Carousel foto dengan 3 foto tampil bersamaan (desktop), 1 foto (mobile)
- Navigasi: tombol panah kiri/kanan (`fa-chevron-left`, `fa-chevron-right`)
- Indikator dot di bawah
- Auto-play setiap 4 detik

**Gambar placeholder** (jika belum ada foto asli): gunakan via.placeholder.com berukuran 400x250, warna abu dengan teks seperti "Kegiatan Inspeksi", "Surveilans 2024", dll.

---

#### Section 5: Pengumuman / Banner Login Internal

**Tampilan:**
- Background: gradient dari var(--primary) ke #1e3a8a
- Padding: 3rem 2rem
- Konten di tengah, text-align: center

**Isi:**
- Icon: `fa-lock-open` warna emas, font-size: 2.5rem
- Judul: `Akses Sistem Manajemen Internal` (warna putih, font-size: 1.5rem)
- Teks: `Petugas dan administrator dapat login untuk mengelola data sertifikat, inspeksi, dan laporan.` (warna rgba(255,255,255,0.8))
- Tombol: `Login ke Sistem →` background: var(--accent), color: #0f172a, font-weight: 700, link ke `/login`

---

### HALAMAN 2: LAYANAN (`/layanan`)

**Blade File:** `resources/views/public/layanan.blade.php`

**Section 1: Page Header**
- Background: gradient navy ke biru, height: 200px
- Teks: `Layanan BALAI PPMHKP LAMPUNG` (judul putih besar, font-size: 2rem, text-align: center)
- Breadcrumb: `Beranda / Layanan` (warna abu, font-size: 0.85rem)

**Section 2: Grid Kartu Layanan (7 layanan)**

Grid 3 kolom (desktop), 2 kolom (tablet), 1 kolom (mobile). Setiap kartu memiliki:
- Icon layanan (Font Awesome)
- Nama layanan (font-weight: 700)
- Deskripsi singkat
- Tombol `Akses Sistem` → link ke URL sistem
- Tombol `Regulasi` → link ke Google Drive folder regulasi
- Badge status: `Aktif` (hijau)

**7 Kartu Layanan:**

1. **SIAPMutu**
   - Icon: `fa-award` warna: #3b82f6 (biru)
   - Nama: `SIAPMutu`
   - Deskripsi: `Sertifikasi Mutu Hasil Kelautan dan Perikanan untuk tujuan ekspor`
   - URL Sistem: `https://siapmutu.kkp.go.id/login`
   - URL Regulasi: `https://drive.google.com/drive/folders/1NVkJWWvtIHhnWkBonIzUxjZhujMD9EQy?usp=drive_link`

2. **HONEST**
   - Icon: `fa-shield-alt` warna: #10b981 (hijau)
   - Nama: `HONEST`
   - Deskripsi: `HACCP Online System — Sistem jaminan keamanan pangan berbasis HACCP`
   - URL Sistem: `https://haccp.kkp.go.id/h4/login/`
   - URL Regulasi: `https://drive.google.com/drive/folders/1vMZdXV1epqd5BnrWj7z3jXr9sxHKuaq7?usp=drive_link`

3. **SKP**
   - Icon: `fa-file-alt` warna: #f59e0b (oranye)
   - Nama: `SKP`
   - Deskripsi: `Penerbitan Sertifikat Kelayakan Pengolahan`
   - URL Sistem: `https://skp-pdspkp.kkp.go.id/skp-online/auth/login`
   - URL Regulasi: `https://drive.google.com/drive/folders/18lvCabQOEHb4gm4TGC9H5Vry3_2FGqcG?usp=drive_link`

4. **OSS**
   - Icon: `fa-globe` warna: #8b5cf6 (ungu)
   - Nama: `OSS`
   - Deskripsi: `Penerbitan Sertifikat CBIB, CPIB, dan CPIB Kapal`
   - URL Sistem: `https://oss.go.id/id`
   - URL Regulasi: `https://drive.google.com/drive/folders/11-Xbqw6iciOsMRjillsM6H6vb93tcYp7?usp=drive_link`

5. **SIMONA**
   - Icon: `fa-chart-line` warna: #ef4444 (merah)
   - Nama: `SIMONA`
   - Deskripsi: `Monitoring Realisasi Anggaran`
   - URL Sistem: `https://siapmutu.kkp.go.id/simona/login`
   - URL Regulasi: *(belum tersedia — tombol Regulasi disabled/abu)*

6. **SILAB**
   - Icon: `fa-flask` warna: #0ea5e9 (biru muda)
   - Nama: `SILAB`
   - Deskripsi: `Sistem Pengendalian Bahan Laboratorium`
   - URL Sistem: `https://siapmutu.kkp.go.id/silab/`
   - URL Regulasi: *(belum tersedia)*

7. **RegMitra**
   - Icon: `fa-handshake` warna: #d4af37 (emas)
   - Nama: `RegMitra`
   - Deskripsi: `Registrasi Negara Mitra ekspor kelautan dan perikanan`
   - URL Sistem: `https://siapmutu.kkp.go.id/ppk/`
   - URL Regulasi: *(belum tersedia)*

---

### HALAMAN 3: SKM (`/skm`)

**Blade File:** `resources/views/public/skm.blade.php`

**Page Header:** sama seperti halaman layanan, judul: `Hasil Survey Kepuasan Masyarakat`

**Section: Grafik SKM Per Tahun**
- Judul section: `Grafik SKM Per Tahun` (font-size: 1.25rem, font-weight: 700, margin-bottom: 1.5rem)
- Deskripsi: `Data hasil survei kepuasan masyarakat terhadap layanan BPPMHKP Lampung, dibandingkan dengan target tahunan.`
- **Bar Chart Chart.js** (label: tahun, 2 dataset: Target (warna biru navy) dan Realisasi (warna emas))
- Data diambil dari tabel `data_skms` via controller, di-pass ke view sebagai JSON
- Di bawah chart: tabel data SKM dengan kolom: Tahun | Target (%) | Realisasi (%) | Keterangan

**Data SKM seeder (contoh):**
```
2020: Target 78%, Realisasi 79.5%
2021: Target 80%, Realisasi 81.2%
2022: Target 80%, Realisasi 82.7%
2023: Target 82%, Realisasi 84.1%
2024: Target 85%, Realisasi 86.3%
```

---

### HALAMAN 4: EKSPOR (`/ekspor`)

**Blade File:** `resources/views/public/ekspor.blade.php`

**Page Header:** judul: `Data Ekspor BPPMHKP Lampung`

**3 Kartu Grafik sejajar (grid 3 kolom desktop, 1 kolom mobile):**

1. **Grafik Frekuensi Ekspor**
   - Tipe chart: Bar Chart
   - Label X: Bulan (Jan–Des)
   - Label Y: Jumlah Pengiriman
   - Warna bar: var(--primary) (#0f172a)
   - Judul di atas chart: `Frekuensi Ekspor`

2. **Grafik Volume Ekspor**
   - Tipe chart: Line Chart
   - Label X: Bulan (Jan–Des)
   - Label Y: Volume (Ton)
   - Warna garis: var(--accent) (#d4af37)
   - Judul: `Volume Ekspor (Ton)`

3. **Grafik Nilai Ekspor**
   - Tipe chart: Bar Chart
   - Label X: Bulan (Jan–Des)
   - Label Y: Nilai (USD)
   - Warna bar: var(--success) (#10b981)
   - Judul: `Nilai Ekspor (USD)`

**Filter tahun:** dropdown pilih tahun di atas grafik, saat berubah data grafik update via AJAX

---

### HALAMAN 5: MEDIA & BERITA (`/media`)

**Blade File:** `resources/views/public/media.blade.php`

**Page Header:** judul: `Media Sosial & Berita`

**Section 1: Media Sosial**
- Judul: `Ikuti Kami di Media Sosial` (text-align: center)
- 5 tombol medsos sejajar (wrap di mobile):

| Platform | Icon | Warna | URL |
|----------|------|-------|-----|
| Instagram | `fa-instagram` | gradient pink-ungu | `https://instagram.com/badanmutukkplampung` |
| YouTube | `fa-youtube` | #ff0000 | `https://www.youtube.com/@badanmutukkplampung` |
| Twitter/X | `fa-x-twitter` | #000000 | `https://x.com/BPPMHKPLampung` |
| WhatsApp | `fa-whatsapp` | #25d366 | `https://api.whatsapp.com/send/?phone=%2B62816245342` |
| Threads | `fa-threads` | #000000 | `https://www.threads.com/@badanmutukkplampung` |
| TikTok | `fa-tiktok` | #000000 | `https://www.tiktok.com/@bppmhkplampung` |

Setiap tombol: ikon + teks nama platform, padding: 0.75rem 1.5rem, border-radius: 8px, target: _blank

**Section 2: Galeri Foto Kegiatan**
- Grid foto 3 kolom (desktop), 2 (tablet), 1 (mobile)
- Setiap foto: border-radius: 8px, hover: scale(1.03), overlay gelap dengan teks caption saat hover

---

### HALAMAN 6: APLIKASI (`/aplikasi`)

**Blade File:** `resources/views/public/aplikasi.blade.php`

**Page Header:** judul: `Kumpulan Aplikasi Layanan Digital BPPMHKP Lampung`

**4 Kelompok Aplikasi (grid 2 kolom desktop, 1 kolom mobile), tiap kelompok punya warna header berbeda:**

**Kelompok 1: Survey Layanan Masyarakat** (warna header: biru)
- Icon: `fa-poll` 
- Aplikasi: Survey Kepuasan Masyarakat → `https://ptsp.kkp.go.id/skm/s/u/46`

**Kelompok 2: Layanan Pengaduan** (warna header: merah)
- Icon: `fa-bullhorn`
- Aplikasi 1: GOL KPK → `https://gol.kpk.go.id/`
- Aplikasi 2: UPG KKP → `https://upg.kkp.go.id/`

**Kelompok 3: Layanan Informasi** (warna header: hijau)
- Icon: `fa-info-circle`
- Aplikasi 1: PPID KKP Lampung → `https://ppid.kkp.go.id/upt/balai-kipm-lampung/`
- Aplikasi 2: JDIH KKP → `https://jdih.kkp.go.id/`

**Kelompok 4: Layanan Smart Guest** (warna header: emas)
- Icon: `fa-user-check`
- Aplikasi: Smart Guest → `https://www.appsheet.com/start/a72f4794-790e-4927-aa4c-bde324630c6b`

---

### HALAMAN 7: REGULASI (`/regulasi`)

**Blade File:** `resources/views/public/regulasi.blade.php`

**Page Header:** judul: `Regulasi & Kebijakan`
**Deskripsi:** `Dokumen regulasi, kebijakan, dan peraturan yang menjadi dasar layanan dan tata kelola BPPMHKP Lampung`

**Tabel regulasi dengan search dan filter:**
- Kolom: No | Judul Regulasi | Kategori | Tahun | Aksi (Unduh)
- Filter by kategori: dropdown
- Search by judul: input text real-time

---

### HALAMAN 8: TENTANG KAMI (`/about`)

**Blade File:** `resources/views/public/about.blade.php`

**Section 1: Profil Organisasi**
- Judul besar: `BALAI PPMHKP LAMPUNG`
- Sub: `Balai Pengendalian dan Pengawasan Mutu dan Keamanan Hasil Kelautan dan Perikanan Lampung`
- Dua kolom: kiri teks, kanan foto kantor/logo besar

**Section 2: Visi**
- Background: var(--primary) (navy gelap), teks putih
- Icon: `fa-eye` emas
- Judul: `VISI`
- Teks lengkap:
  > *Terselenggaranya pengendalian dan pengawasan mutu yang terdepan untuk memastikan keamanan, kualitas, keberlanjutan dan daya saing hasil kelautan dan perikanan, dalam rangka mewujudkan masyarakat kelautan dan perikanan yang sejahtera dan sumber daya kelautan dan perikanan yang berkelanjutan untuk Indonesia maju yang berdaulat, mandiri, berkepribadian, berlandaskan gotong royong.*

**Section 3: Misi**
- 5 poin misi dengan icon centang emas (`fa-check-circle`):
  1. Meningkatkan daya saing hasil kelautan dan perikanan melalui inspeksi, sertifikasi, surveilans, pengambilan contoh uji, pengujian dan monitoring.
  2. Meningkatkan penerapan praktik yang baik di setiap rantai pasok dan kepatuhan terhadap pemenuhan standar mutu hasil kelautan dan perikanan.
  3. Mewujudkan sistem jaminan mutu dan keamanan hasil kelautan dan perikanan yang efektif dan selaras dengan standar internasional.
  4. Meningkatkan tata kelola pemerintahan yang bersih, efektif, dan terpercaya.

**Section 4: Tugas & Fungsi**
- Dua kartu sejajar:
  - **Tugas:** Menyelenggarakan Pengendalian dan pengawasan mutu dan keamanan hasil kelautan dan perikanan.
  - **Fungsi:** 4 poin fungsi (list)

**Section 5: Struktur Organisasi**
- Judul: `Struktur Organisasi`
- Placeholder gambar: kotak abu-abu dengan teks "Struktur Organisasi" (nanti diganti gambar asli)

**Section 6: Lokasi Kantor**
- Judul: `Lokasi Kantor`
- Embed Google Maps (iframe responsif):
```html
<div style="width:100%; height:400px; border-radius:12px; overflow:hidden;">
  <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.038181145026!2d105.29224637498406!3d-5.411156094568006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40db9eb030fbdb%3A0xe50f9cdc317446e3!2sBKIPM%20Lampung!5e0!3m2!1sid!2sid!4v1767596520737!5m2!1sid!2sid"
    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
    referrerpolicy="no-referrer-when-downgrade">
  </iframe>
</div>
```

---

### Footer Portal Publik

**Tampilan:**
- Background: var(--primary) (#0f172a)
- Warna teks: rgba(255,255,255,0.7)
- Padding: 3rem 2rem 1.5rem
- 3 kolom (desktop), 1 kolom (mobile):

**Kolom 1 — Identitas:**
- Logo KKP + Logo BPPMHKP sejajar (filter: brightness(0) invert(1) agar terlihat di background gelap)
- Teks: `Balai PPMHKP Lampung` (warna putih, font-weight: 700)
- Tagline: `Sistem Pengendalian & Pengawasan Mutu Hasil Kelautan dan Perikanan`

**Kolom 2 — Navigasi Cepat:**
- Judul: `Navigasi` (warna putih)
- Link: Beranda, Layanan, SKM, Data Ekspor, Media, Aplikasi, Regulasi, Tentang Kami

**Kolom 3 — Kontak:**
- Judul: `Hubungi Kami` (warna putih)
- WhatsApp: `+62 816 245 342`
- Instagram: `@badanmutukkplampung`
- Email placeholder

**Bottom bar:** `© 2024 Balai PPMHKP Lampung. Semua hak dilindungi.` | `Kementerian Kelautan dan Perikanan`

---

## 8. BAGIAN B: SISTEM INTERNAL (LOGIN REQUIRED)

### Layout Internal (`layouts/internal.blade.php`)

Struktur layout internal:
```html
<body class="{{ dark_mode ? 'dark-mode' : '' }}">
  <aside class="sidebar">          ← Sidebar kiri tetap (fixed)
    [header logo]
    [nav menu sesuai role]
    [user profile + logout di bawah]
  </aside>
  <div class="main-content">       ← Konten utama, margin-left: 260px
    <header class="header">        ← Topbar sticky
      [judul halaman] [search] [notif] [dark toggle] [user info]
    </header>
    <div class="content-area">     ← Area konten, overflow-y: auto, padding: 2rem
      @yield('content')
    </div>
  </div>
  [toast-container]                ← Notifikasi pop-up pojok kanan atas
</body>
```

---

### SIDEBAR — Desain Detail

**Dimensi & Posisi:**
- `width: 260px`
- `position: fixed; left: 0; top: 0; height: 100vh; z-index: 50;`
- `overflow-y: auto;`
- Background: `var(--bg-surface)` (putih di light, #252d3d di dark)
- `border-right: 1px solid var(--border-color);`

**Bagian 1 — Sidebar Header (`sidebar-header`):**
- Padding: 1.5rem
- `display: flex; align-items: center; gap: 12px; justify-content: space-between;`
- `border-bottom: 1px solid var(--border-color);`
- Kiri: icon jangkar `fa-anchor` warna var(--accent) font-size: 1.2rem
- Tengah: teks `ONE` (warna var(--primary), font-weight: 700) + `TOUCH` (warna var(--accent), font-weight: 700), font-size: 1.1rem
- Kanan (mobile only): tombol close `fa-times` icon, `display: none` di desktop, muncul di mobile ≤ 768px

**Bagian 2 — Nav Menu (`nav-menu`):**
- Padding: 1.5rem 1rem
- `flex: 1`
- Setiap nav item (`nav-item`): `margin-bottom: 0.5rem`
- Nav link style:
  ```css
  .nav-link {
    display: flex; align-items: center; gap: 12px;
    padding: 0.75rem 1rem;
    color: var(--text-muted);
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s;
    cursor: pointer;
  }
  .nav-link:hover { background: #f8fafc; color: var(--primary); }
  .nav-link.active {
    background: #eff6ff;
    color: var(--primary);
    font-weight: 600;
    border-left: 3px solid var(--primary);
    padding-left: calc(1rem - 3px);
  }
  .nav-link i { width: 20px; text-align: center; }
  ```
- Dark mode: `.nav-link:hover { background: #3f4759; }` | `.nav-link.active { background: rgba(212,175,55,0.15); }`

**Menu per Role:**

| Menu Item | Icon Font Awesome | Admin | Petugas | User |
|-----------|------------------|-------|---------|------|
| Dashboard | `fa-gauge` | ✅ | ✅ | ✅ |
| Data Sertifikat | `fa-certificate` | ✅ | ✅ | ✅ |
| Inspeksi & Surveilan | `fa-clipboard-check` | ✅ | ✅ | ✅ |
| Manajemen User | `fa-users` | ✅ hanya | ❌ | ❌ |
| Laporan & Rekap | `fa-print` | ✅ | ✅ | ✅ |

**Bagian 3 — Sidebar Footer:**
- `border-top: 1px solid var(--border-color); padding: 1rem; margin-top: auto;`
- User profile card:
  ```
  [Avatar bulat 36x36px, background: var(--accent), inisial huruf pertama nama]
  [Nama user — font-weight: 600, font-size: 0.9rem]
  [Role — font-size: 0.75rem, color: var(--text-muted)]
  ```
- Tombol Logout: lebar penuh, background: transparent, border: 1px solid var(--border-color), icon `fa-sign-out-alt`, teks: `Logout`, margin-top: 0.75rem

---

### TOPBAR / HEADER INTERNAL

**Tampilan:**
- `background: var(--bg-surface);`
- `border-bottom: 1px solid var(--border-color);`
- `padding: 1rem 2rem;`
- `display: flex; justify-content: space-between; align-items: center; gap: 2rem;`

**Sisi Kiri:**
- Tombol hamburger menu (mobile only, `fa-bars`): `display: none` di desktop
- Judul halaman (`h1`): font-size: 1.5rem, color: var(--primary), font-weight: 600

**Sisi Kanan (header-actions):**
- Search box: background: #f8fafc, border: 1px solid var(--border-color), border-radius: 8px, icon `fa-search` abu + input text placeholder "Cari sertifikat...", width input: 200px
- Ikon notifikasi (`fa-bell`): tombol bundar, jika ada notifikasi tampil badge merah bulat kecil di pojok kanan atas icon dengan angka jumlah notifikasi
- Tombol dark mode: icon bulan/matahari, background: #f8fafc, border: 1px solid var(--border-color), border-radius: 8px
- Info user (kanan paling ujung): `flex; gap: 8px; align-items: center;`
  - Teks nama user: font-weight: 600, font-size: 0.9rem
  - Teks role: font-size: 0.75rem, color: var(--text-muted)
  - Avatar: div bulat 36x36px, background: var(--accent), inisial putih, font-weight: bold

---

### HALAMAN: DASHBOARD INTERNAL

**URL Admin:** `/admin/dashboard`
**URL Petugas:** `/petugas/dashboard`
**URL User:** `/user/dashboard`

**Section 1: Page Title**
```html
<div style="margin-bottom: 1.5rem;">
  <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--primary);">Ringkasan Kondisi Sertifikat</h2>
  <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 0.25rem;">Beranda / Dashboard</p>
</div>
```

**Section 2: 4 Stat Cards (grid 4 kolom desktop, 2 kolom tablet, 1 kolom mobile)**

```
Kartu 1: Total Sertifikat
- Border kiri: 4px solid var(--info) (#3b82f6)
- Icon: fa-folder-open, warna: var(--info)
- Label: "Total Sertifikat" (uppercase, font-size: 0.8rem, color: var(--text-muted))
- Nilai: angka dari DB (font-size: 2rem, font-weight: 700, color: var(--primary))

Kartu 2: Sertifikat Aktif
- Border kiri: 4px solid var(--success) (#10b981)
- Icon: fa-check-circle, warna: var(--success)
- Label: "Sertifikat Aktif"
- Nilai: angka dari DB

Kartu 3: Segera Kadaluwarsa
- Border kiri: 4px solid var(--warning) (#f59e0b)
- Icon: fa-clock, warna: var(--warning)
- Label: "Segera Kadaluwarsa" (sertifikat dalam 90 hari ke depan)
- Nilai: angka dari DB

Kartu 4: Sudah Kadaluwarsa
- Border kiri: 4px solid var(--danger) (#ef4444)
- Icon: fa-exclamation-triangle, warna: var(--danger)
- Label: "Sudah Kadaluwarsa"
- Nilai: angka dari DB
```

**Style Stat Card:**
```css
.stat-card {
  background: var(--bg-surface);
  border: 1px solid var(--border-color);
  border-radius: 12px;
  padding: 1.5rem;
  transition: all 0.3s;
  box-shadow: var(--shadow-sm);
  position: relative;
  overflow: hidden;
}
.stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
```

**Section 3: 2 Chart Sejajar (grid 2 kolom desktop, 1 kolom mobile)**

**Kartu Chart 1: Distribusi Kategori Sertifikat**
- Tipe: `doughnut`
- Data: jumlah sertifikat per jenis (HACCP, SKP, SPDI, CPIB, CBIB)
- Warna: `['#0f172a', '#d4af37', '#3b82f6', '#10b981', '#f59e0b']`
- Legend: `position: 'bottom'`
- Judul kartu: `Distribusi Kategori Sertifikat`

**Kartu Chart 2: Statistik Status Masa Berlaku (Admin/Petugas) atau Status Proses Sertifikat (User)**
- Tipe: `bar`
- Admin/Petugas data: Aktif | Segera Kadaluwarsa | Kadaluwarsa
- User data: Pending | Process | Completed
- Warna bar: `['#dcfce7', '#fef3c7', '#fee2e2']` (hijau muda, kuning muda, merah muda)
- Grid: `display: false` untuk x dan y axis
- Legend: `display: false`

**Section 4: Tabel Perhatian Kritis**

- Judul kartu: `Perhatian Kritis (N)` di kiri, tombol `Lihat Semua` di kanan (link ke /sertifikat)
- Sub judul: `Sertifikat yang telah habis masa berlakunya atau akan berakhir dalam 30 hari ke depan.`
- Kolom tabel:
  - Admin/Petugas: `NAMA PEMILIK` | `JENIS SERTIFIKAT` | `TGL KADALUWARSA` | `STATUS`
  - User: `NAMA PEMILIK` | `JENIS SERTIFIKAT` | `STATUS PROSES` | `TGL KADALUWARSA` | `STATUS MASA`
- Hanya tampilkan 3–5 baris (terbatas, bukan semua data)
- Data hanya milik user sendiri jika role = user

---

### HALAMAN: DATA SERTIFIKAT

**URL Admin:** `/admin/sertifikat`
**URL Petugas:** `/petugas/sertifikat`
**URL User:** `/user/sertifikat`

**Header halaman:**
```
[Judul: "Manajemen Data Sertifikat"] [tombol "+ Tambah Sertifikat" — background: var(--primary), warna: putih] ← kanan atas
[breadcrumb: Data / Sertifikat]
```
*(Tombol Tambah HANYA tampil untuk Admin dan Petugas. User tidak punya tombol ini.)*

**Area filter/search:**
- Input search: placeholder `Cari nama, nomor...`, width: 280px
- Dropdown filter status: `Semua Status` | `Aktif` | `Segera Kadaluwarsa` | `Kadaluwarsa`, max-width: 160px
- (Hanya Admin: tambah filter kepemilikan user)

**Tabel Sertifikat:**

| Kolom | Keterangan |
|-------|-----------|
| `NAMA` | Nama perusahaan/kapal pemilik sertifikat |
| `NOMOR` | Nomor sertifikat, contoh: 530/HACCP/2023 |
| `RUANG LINGKUP` | Badge abu (contoh: Pengolahan Ikan, Kapal Penangkap Ikan) |
| `JENIS SERTIFIKAT` | HACCP / SKP / SPDI / CPIB / CBIB |
| `GRADE` | Badge huruf A/B/C dalam lingkaran kecil |
| `TGL TERBIT` | Format: YYYY-MM-DD |
| `TGL KADALUWARSA` | Format: YYYY-MM-DD |
| `STATUS` | Badge warna: Aktif (hijau) / Segera Kadaluwarsa (kuning) / Kadaluwarsa (merah) |
| `AKSI` | Admin/Petugas: icon eye👁 + icon pensil✏ + icon trash🗑 | User: hanya eye👁 |

**Style tabel:**
```css
th {
  background: #f8fafc;
  padding: 0.75rem 1rem;
  text-align: left;
  font-weight: 600;
  font-size: 0.85rem;
  color: var(--text-muted);
  border-bottom: 2px solid var(--border-color);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
td {
  padding: 0.75rem 1rem;
  border-bottom: 1px solid var(--border-color);
}
tr:hover { background: #f8fafc; }
```

**Modal Tambah/Edit Sertifikat** (untuk Admin dan Petugas):

Modal overlay gelap `rgba(0,0,0,0.5)`, kartu modal max-width: 500px, border-radius: 12px, animation: slideUp (dari bawah 20px ke posisi normal).

**Header modal:** `Tambah Sertifikat` atau `Edit Sertifikat` | tombol close X

**Body modal — field form:**
1. **Nama Perusahaan / Kapal** — `type="text"`, required
2. **Nomor Sertifikat** — `type="text"`, required, placeholder: `contoh: 530/HACCP/2023`
3. **Ruang Lingkup** — `type="text"`, placeholder: `Ketik atau pilih...`, required (Pengolahan Ikan / Kapal Penangkap Ikan / Distribusi / Cold Storage / Pelabuhan Perikanan)
4. **Jenis Sertifikat** — `<select>`: HACCP | SKP | SPDI | CPIB | CBIB
5. **Grade** — `<select>`: A | B | C
6. **Tanggal Terbit** — `type="date"`, required
7. **Tanggal Kadaluwarsa** — `type="date"`, required
8. **Status** — `<select>`: Aktif | Kadaluwarsa

Field nomor sertifikat, ruang lingkup, jenis sertifikat, grade dalam 2 kolom (grid 2 kolom, gap: 1rem).
Field tanggal terbit dan tanggal kadaluwarsa dalam 2 kolom.
Field nama dan status masing-masing full-width.

**Footer modal:** tombol `Batal` (outline) di kiri, tombol `Simpan` (background: var(--primary), warna putih) di kanan.

---

### HALAMAN: INSPEKSI & SURVEILAN

**URL Admin:** `/admin/inspeksi`
**URL Petugas:** `/petugas/inspeksi`
**URL User:** `/user/inspeksi`

**Header halaman:**
```
[Judul: "Inspeksi & Surveilan"] [tombol "+ Tambah Data" — hanya Admin dan Petugas]
[breadcrumb: Monitoring / Inspeksi]
```

**Filter:** dropdown `Semua Kategori` | `Inspeksi` | `Surveilan`, max-width: 200px

**Tabel Inspeksi:**

| Kolom | Admin/Petugas | User |
|-------|--------------|------|
| `NAMA PERUSAHAAN` | ✅ | ❌ (tidak perlu, sudah diketahui) |
| `TANGGAL` | ✅ | ✅ |
| `KATEGORI` | ✅ badge | ✅ badge |
| `JENIS SERTIFIKAT` | ✅ | ✅ |
| `PEMILIK (USER)` | ✅ (admin/petugas perlu tahu) | ❌ |
| `BERKAS` | ✅ badge Terkirim/Tidak Ada | ✅ badge Terkirim/Tidak Ada |
| `AKSI` | ✅ edit+hapus+unduh | ✅ hanya unduh (jika Terkirim) |

**Modal Tambah Data Inspeksi** (Admin dan Petugas):

Field form:
1. **Nama Perusahaan** — `type="text"`, required
2. **Tanggal** — `type="date"`, required
3. **Kategori** — `<select>`: Inspeksi | Surveilan
4. **Jenis Sertifikat** — `<select>`: HACCP | SKP | SPDI | CPIB | CBIB
5. **Upload Berkas (PDF/DOCX)** — `type="file"`, accept: `.pdf,.doc,.docx`, hint teks: `Tidak ada file dipilih`

Field Tanggal dan Kategori dalam 2 kolom.
Field Upload Berkas full-width.

---

### HALAMAN: MANAJEMEN USER (Admin Only)

**URL:** `/admin/users`

**Header:**
```
[Judul: "Manajemen User"] [tombol "+ Tambah User" — kanan atas]
[breadcrumb: Admin / Pengguna]
```

**Tabel User:**

| Kolom | Detail |
|-------|--------|
| `NAMA LENGKAP` | Nama user |
| `USERNAME` | Username login |
| `ROLE` | Badge: ADMIN (ungu) / OFFICER (biru) / USER (biru muda) |
| `AKSI` | icon pensil✏ + icon trash🗑 |

**Modal Tambah/Edit User:**

Field:
1. **Nama Lengkap** — `type="text"`, required
2. **Username** — `type="text"`, required
3. **Password** — `type="password"`, required (pada edit: placeholder `Kosongkan jika tidak ingin mengubah`)
4. **Role** — `<select>`: admin | petugas | user
5. **Nama Perusahaan** (muncul hanya jika Role = user) — `type="text"` conditional show/hide via JS

---

### HALAMAN: LAPORAN & REKAP

**URL Admin:** `/admin/laporan`
**URL Petugas:** `/petugas/laporan`
**URL User:** `/user/laporan`

**Untuk Admin:**
- Judul: `Pusat Laporan & Ekspor Data`
- Breadcrumb: `Admin / Laporan`
- Kartu laporan: `Preview Laporan Sertifikat Aktif`
  - Tombol `PDF` (merah, icon `fa-file-pdf`) di kanan kartu
  - Tombol `Excel` (hijau, icon `fa-file-excel`) di sebelah PDF
  - Tabel: `NAMA PEMILIK` | `JENIS` | `STATUS` | `KADALUWARSA`
  - Hanya tampilkan sertifikat status Aktif

**Untuk Petugas:**
- Sama dengan Admin tapi data terbatas pada yang diinput petugas tersebut

**Untuk User:**
- Judul: `Laporan Sertifikat Saya`
- Tabel: `NAMA` | `JENIS` | `STATUS PROSES` | `TANGGAL` 
- Tombol Export PDF dan Excel (hanya untuk data milik user tersebut)

---

## 9. KOMPONEN UI REUSABLE

### Toast Notification
```javascript
// Container: position fixed, top: 20px, right: 20px, z-index: 1000
// Toast item:
//   background: var(--bg-surface)
//   border-left: 4px solid [warna sesuai type]
//   padding: 1rem, border-radius: 8px, margin-bottom: 0.5rem
//   display: flex; align-items: center; gap: 1rem;
//   min-width: 300px
//   animation: slideIn dari kanan (translateX(100%) ke 0)
//   Auto-remove setelah 3 detik
// Types: info (biru), success (hijau), warning (kuning), danger (merah)

function showToast(message, type = 'info') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = 'toast';
    const colors = { info: '#3b82f6', success: '#10b981', warning: '#f59e0b', danger: '#ef4444' };
    const icons = { info: 'fa-info-circle', success: 'fa-check-circle', warning: 'fa-exclamation-triangle', danger: 'fa-times-circle' };
    toast.style.borderLeftColor = colors[type];
    toast.innerHTML = `<i class="fa-solid ${icons[type]}" style="color: ${colors[type]};"></i><span>${message}</span>`;
    container.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; toast.style.transform = 'translateX(100%)'; setTimeout(() => toast.remove(), 300); }, 3000);
}
```

### Dark Mode Toggle
```javascript
// Simpan preferensi di localStorage key: 'onetouchTheme'
// Toggle class 'dark-mode' pada <body>
// Icon: fa-moon (saat light mode — klik untuk dark), fa-sun (saat dark mode — klik untuk light)

function toggleDarkMode() {
    const body = document.body;
    body.classList.toggle('dark-mode');
    const isDark = body.classList.contains('dark-mode');
    localStorage.setItem('onetouchTheme', isDark ? 'dark' : 'light');
    document.querySelector('.theme-toggle i').className = isDark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
    // Re-render chart dengan warna yang disesuaikan
}

// Pada load halaman:
document.addEventListener('DOMContentLoaded', function() {
    const saved = localStorage.getItem('onetouchTheme');
    if (saved === 'dark') {
        document.body.classList.add('dark-mode');
        document.querySelector('.theme-toggle i').className = 'fa-solid fa-sun';
    }
});
```

### Mobile Sidebar Toggle
```javascript
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('open');
}
// Sidebar di mobile (≤768px): position fixed, transform: translateX(-100%) default
// Saat .open: transform: translateX(0)
// Ada overlay gelap semi-transparan di belakang sidebar saat terbuka di mobile
```

### Notifikasi Kadaluwarsa (Laravel Scheduler)
```php
// app/Console/Commands/CheckExpiringSertifikats.php
// Jalankan setiap hari tengah malam
// Cari sertifikat dengan tanggal_kadaluwarsa <= CURDATE() + 30 HARI
// Update status_masa ke 'warning' atau 'expired'
// Simpan notifikasi ke session atau tabel notifications
```

---

## 10. RESPONSIVITAS & BREAKPOINTS

Gunakan CSS Media Queries berikut secara konsisten:

```css
/* Desktop (default): ≥ 1024px — tidak perlu media query */
/* Tablet: 768px – 1023px */
@media (max-width: 1023px) {
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
  .charts-container { grid-template-columns: 1fr; }
}

/* Mobile: ≤ 767px */
@media (max-width: 767px) {
  /* Sidebar */
  .sidebar {
    transform: translateX(-100%);
    position: fixed;
    z-index: 1000;
  }
  .sidebar.open { transform: translateX(0); }
  .sidebar-close { display: block !important; }  /* Tombol X muncul */
  .main-content { margin-left: 0 !important; }
  
  /* Header */
  .header { padding: 1rem; gap: 0.5rem; }
  .header-title h1 { font-size: 1.1rem; }
  .search-box { display: none; }  /* Search disembunyikan di mobile */
  .hamburger-btn { display: flex !important; } /* Tombol hamburger muncul */
  
  /* Content */
  .content-area { padding: 1rem; }
  .stats-grid { grid-template-columns: 1fr; }
  .charts-container { grid-template-columns: 1fr; }
  
  /* Tables: scroll horizontal */
  .table-container { overflow-x: auto; -webkit-overflow-scrolling: touch; }
  table { min-width: 600px; }
  th, td { padding: 0.5rem 0.75rem; font-size: 0.8rem; }
  
  /* Modals */
  .modal { margin: 1rem; max-width: calc(100vw - 2rem); }
  
  /* Navbar publik */
  .nav-desktop { display: none; }
  .hamburger-public { display: flex !important; }
}

/* Print */
@media print {
  .sidebar, .header, .btn, .theme-toggle, .search-box { display: none !important; }
  .main-content { margin-left: 0; }
  .content-area { padding: 0; }
  body { background: white; }
}
```

---

## 11. PANDUAN MIGRASI & SEEDER DATABASE

### Urutan Migrasi:
1. `create_users_table`
2. `create_sertifikats_table`
3. `create_inspeksis_table`
4. `create_data_skms_table`
5. `create_data_ekspors_table`

### Seeder Data Awal:

**UserSeeder** (buat di `database/seeders/UserSeeder.php`):
```php
// Admin
['name' => 'Super Admin', 'username' => 'admin', 'password' => Hash::make('password123'), 'role' => 'admin']

// Petugas
['name' => 'Petugas Inspeksi', 'username' => 'petugas', 'password' => Hash::make('password123'), 'role' => 'petugas']

// User
['name' => 'PT. Bahari Makmur', 'username' => 'user', 'password' => Hash::make('password123'), 'role' => 'user', 'company_name' => 'PT. Bahari Makmur']
```

**SertifikatSeeder** (buat 5 data contoh):
```php
[
  ['nama_pemilik' => 'PT. Bahari Makmur', 'nomor_sertifikat' => '530/HACCP/2023', 'ruang_lingkup' => 'Pengolahan Ikan', 'jenis_sertifikat' => 'HACCP', 'grade' => 'A', 'tanggal_terbit' => '2025-04-16', 'tanggal_kadaluwarsa' => '2026-04-11', 'status_masa' => 'aktif', 'status_proses' => 'Completed', 'user_id' => 3],
  ['nama_pemilik' => 'KM. Samudra Jaya', 'nomor_sertifikat' => '540/SKP/2023', 'ruang_lingkup' => 'Kapal Penangkap Ikan', 'jenis_sertifikat' => 'SKP', 'grade' => 'B', 'tanggal_terbit' => '2025-07-25', 'tanggal_kadaluwarsa' => '2026-08-29', 'status_masa' => 'aktif', 'status_proses' => 'Completed', 'user_id' => 1],
  ['nama_pemilik' => 'UD. Ikan Segar', 'nomor_sertifikat' => '515/SPDI/2022', 'ruang_lingkup' => 'Distribusi', 'jenis_sertifikat' => 'SPDI', 'grade' => 'A', 'tanggal_terbit' => '2025-01-06', 'tanggal_kadaluwarsa' => '2026-01-31', 'status_masa' => 'expired', 'status_proses' => 'Completed', 'user_id' => 1],
  ['nama_pemilik' => 'CV. Ocean Harvest', 'nomor_sertifikat' => '520/SMKHP/2023', 'ruang_lingkup' => 'Cold Storage', 'jenis_sertifikat' => 'CPIB', 'grade' => 'A', 'tanggal_terbit' => '2025-11-02', 'tanggal_kadaluwarsa' => '2026-02-25', 'status_masa' => 'warning', 'status_proses' => 'Completed', 'user_id' => 1],
  ['nama_pemilik' => 'PT. Perindo Tbk', 'nomor_sertifikat' => '001/CBIB/2024', 'ruang_lingkup' => 'Pelabuhan Perikanan', 'jenis_sertifikat' => 'CBIB', 'grade' => 'A', 'tanggal_terbit' => '2025-12-22', 'tanggal_kadaluwarsa' => '2026-02-15', 'status_masa' => 'warning', 'status_proses' => 'Completed', 'user_id' => 1],
]
```

**InspeksiSeeder** (3 data contoh):
```php
[
  ['nama_perusahaan' => 'PT. Bahari Makmur', 'tanggal' => '2023-10-01', 'kategori' => 'Inspeksi', 'jenis_sertifikat' => 'HACCP', 'status_berkas' => 'Terkirim', 'user_id' => 3],
  ['nama_perusahaan' => 'KM. Samudra Jaya', 'tanggal' => '2023-09-15', 'kategori' => 'Surveilan', 'jenis_sertifikat' => 'SKP', 'status_berkas' => 'Tidak Ada', 'user_id' => 1],
  ['nama_perusahaan' => 'CV. Ocean Harvest', 'tanggal' => '2023-11-01', 'kategori' => 'Inspeksi', 'jenis_sertifikat' => 'CPIB', 'status_berkas' => 'Terkirim', 'user_id' => 1],
]
```

**DataSkmSeeder:**
```php
[
  ['tahun' => 2020, 'target' => 78.00, 'realisasi' => 79.50],
  ['tahun' => 2021, 'target' => 80.00, 'realisasi' => 81.20],
  ['tahun' => 2022, 'target' => 80.00, 'realisasi' => 82.70],
  ['tahun' => 2023, 'target' => 82.00, 'realisasi' => 84.10],
  ['tahun' => 2024, 'target' => 85.00, 'realisasi' => 86.30],
]
```

---

## 12. URUTAN PENGERJAAN YANG DISARANKAN

Ikuti urutan ini agar project bisa ditest secara bertahap:

**Fase 1 — Setup Package & Database (dari terminal di `C:\laragon\www\OneTouch`):**
```bash
# 1. Install package PDF
composer require barryvdh/laravel-dompdf:^2.0

# 2. Install package Excel
composer require maatwebsite/excel:^3.1

# 3. Publish config Excel
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config

# 4. Buat symlink storage
php artisan storage:link

# 5. Konfigurasi .env — pastikan bagian DB sudah benar:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=OneTouch
# DB_USERNAME=root
# DB_PASSWORD=         (kosong jika Laragon default)

# 6. Buat semua migrasi
php artisan make:migration create_sertifikats_table
php artisan make:migration create_inspeksis_table
php artisan make:migration create_data_skms_table
php artisan make:migration create_data_ekspors_table

# 7. Edit masing-masing file migrasi sesuai schema di Bagian 3
# Lalu jalankan:
php artisan migrate

# 8. Buat seeder
php artisan make:seeder UserSeeder
php artisan make:seeder SertifikatSeeder
php artisan make:seeder InspeksiSeeder
php artisan make:seeder DataSkmSeeder
php artisan make:seeder DataEksporSeeder

# 9. Edit DatabaseSeeder.php untuk memanggil semua seeder
# Lalu jalankan:
php artisan db:seed
```

> ⚠️ **PENTING untuk migration `users` table:** Laravel 10 sudah punya migration `create_users_table`. JANGAN buat ulang. Cukup buat migration baru untuk **menambah kolom**:
> ```bash
> php artisan make:migration add_role_and_company_to_users_table
> ```
> Isi migration:
> ```php
> Schema::table('users', function (Blueprint $table) {
>     $table->string('username')->unique()->after('name');
>     $table->enum('role', ['admin', 'petugas', 'user'])->default('user')->after('username');
>     $table->string('company_name')->nullable()->after('role');
> });
> ```
> Juga ubah field `email` agar nullable (karena kita pakai `username` untuk login):
> ```php
> $table->string('email')->nullable()->change();
> ```
> Install doctrine/dbal dulu agar `->change()` bisa dipakai di Laravel 10:
> ```bash
> composer require doctrine/dbal:^3.0
> ```

**Fase 2 — Auth System:**
- Buat `app/Http/Middleware/RoleMiddleware.php` (lihat kode di Bagian 6)
- Daftarkan di `app/Http/Kernel.php` pada `$middlewareAliases`
- Edit `app/Models/User.php` — hapus trait HasFactory jika tidak dipakai, tambahkan relasi
- Buat `app/Http/Controllers/Auth/LoginController.php` (lihat kode di Bagian 6)
- Buat view `resources/views/auth/login.blade.php` sesuai desain di Bagian 6
- Test: akses `http://OneTouch.test/login`, login dengan admin/password123

**Fase 3 — Layout Internal:**
- Buat `resources/views/layouts/internal.blade.php` (sidebar + topbar + dark mode)
- Buat dashboard untuk admin, petugas, user
- Test navigasi sidebar dan responsivitas mobile

**Fase 4 — CRUD Internal:**
- Admin: Sertifikat (index + modal add/edit/delete via AJAX atau form)
- Admin: Inspeksi (index + modal add + upload file)
- Admin: Manajemen User
- Admin: Laporan + Export PDF + Export Excel
- Petugas: Sertifikat CRUD, Inspeksi CRUD, Laporan
- User: Sertifikat view-only, Inspeksi view-only, Laporan + export

**Fase 5 — Portal Publik:**
- Buat `resources/views/layouts/public.blade.php`
- Buat semua 8 halaman publik sesuai urutan di Bagian 7

**Fase 6 — Scheduler & Polishing:**
- Edit `app/Console/Kernel.php` untuk menambah scheduled task update status sertifikat
- Toast notification di semua aksi CRUD
- Konfirmasi delete dengan JavaScript confirm()
- Test semua halaman di mobile (gunakan DevTools Chrome)
- Test dark mode di semua halaman

---

## ⚠️ CATATAN PENTING UNTUK AI AGENT

1. **Framework adalah Laravel 10.50.2, PHP 8.1** — JANGAN gunakan syntax Laravel 11 seperti `bootstrap/app.php`, `->withMiddleware()`, dll.
2. **Middleware didaftarkan di `app/Http/Kernel.php`** pada array `$middlewareAliases`, bukan `bootstrap/app.php`.
3. **Scheduler didaftarkan di `app/Console/Kernel.php`** method `schedule()`, bukan `routes/console.php`.
4. **TIDAK menggunakan Spatie HasRoles** — role disimpan sebagai kolom ENUM `role` di tabel `users` dengan nilai `'admin'`, `'petugas'`, `'user'`.
5. **Jangan install Breeze/Jetstream** — auth dibuat manual dengan `LoginController`.
6. **Jangan gunakan Bootstrap** — gunakan CSS custom dengan variabel CSS (lihat Bagian 4).
7. **Font Awesome, Chart.js, Inter font** hanya via CDN, tidak perlu npm/vite.
8. **Setiap tabel harus punya `overflow-x: auto`** di wrapper-nya agar responsive.
9. **Dark mode** tersimpan di `localStorage` key `onetouchTheme`, bekerja di semua halaman.
10. **Warna emas `#d4af37`** = aksen brand. **Navy `#0f172a`** = primary brand. Konsisten di semua halaman.
11. **Role check di Controller via middleware** — jangan hanya di View.
12. **File upload** disimpan di `storage/app/public/berkas/`, diakses via `asset('storage/berkas/...')` setelah `php artisan storage:link`.
13. **Status sertifikat** dihitung otomatis: `tanggal_kadaluwarsa < TODAY()` → `expired`; `<= TODAY() + 90 hari` → `warning`; lainnya → `aktif`.
14. **Semua teks konten menggunakan Bahasa Indonesia.**
15. **Login menggunakan field `username`** (bukan `email`) — pastikan `config/auth.php` sudah dikonfigurasi untuk menggunakan `username`.
16. **Untuk export Excel di PHP 8.1**, gunakan `maatwebsite/excel ^3.1` yang sudah support PHP 8.1.
17. **Untuk export PDF**, gunakan `barryvdh/laravel-dompdf ^2.0` yang support PHP 8.1.
18. **Kolom `email` di tabel `users`** dibuat nullable karena kita pakai `username` untuk login.
19. **Untuk mengubah kolom yang sudah ada** (alter table), install `composer require doctrine/dbal:^3.0` terlebih dahulu.
20. **URL nama route** menggunakan prefix: `admin.dashboard`, `petugas.dashboard`, `user.dashboard` — gunakan `route('admin.dashboard')` di blade.

---

*Dokumen ini dibuat berdasarkan analisis file zip `ONETOCH.zip` dan disesuaikan dengan environment aktual:*
*Laravel 10.50.2 | PHP 8.1 | MySQL 8.0 | Laragon | Windows | `http://OneTouch.test`*

*Versi dokumen: 2.0 — Diperbarui: 18 Februari 2026*
