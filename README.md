# ONE TOUCH — Sistem Layanan Terpadu Balai PPMHKP Lampung

> **Balai Pengujian, Penerapan Mutu dan Hasil Kelautan dan Perikanan (PPMHKP) Lampung**
> Kementerian Kelautan dan Perikanan — Republik Indonesia

---

## Daftar Isi

1. [Tentang Proyek](#tentang-proyek)
2. [Tech Stack](#tech-stack)
3. [Struktur Folder](#struktur-folder)
4. [Database & Tabel](#database--tabel)
5. [Alur Request](#alur-request)
6. [Hubungan Antar File](#hubungan-antar-file)
7. [Sistem Autentikasi & Role](#sistem-autentikasi--role)
8. [Portal Publik](#portal-publik-8-halaman)
9. [Sistem Internal](#sistem-internal-3-panel)
10. [Dark / Light Mode](#dark--light-mode)
11. [Akun Demo](#akun-demo)
12. [Instalasi](#instalasi)
13. [Export PDF & Excel](#export-pdf--excel)

---

## Tentang Proyek

ONE TOUCH adalah sistem layanan digital terpadu yang terdiri dari dua bagian:

| Bagian | URL | Akses |
|--------|-----|-------|
| **Portal Publik** | `/` sampai `/tentang-kami` | Semua orang, tanpa login |
| **Sistem Internal** | `/admin`, `/officer`, `/user` | Login required + role-based |

**Fungsi utama:**
- Informasi layanan sertifikasi hasil perikanan (HACCP, SKP, SPDI, HC, dll)
- Grafik publik: Survey Kepuasan Masyarakat (SKM) & Data Ekspor
- Manajemen sertifikat & inspeksi (admin & officer)
- Laporan PDF & Excel per role

---

## Tech Stack

```
Backend:  Laravel 10 (PHP 8.1+)
Database: MySQL / MariaDB
Frontend: Blade Templates + Vanilla CSS (CSS Custom Properties) + Vanilla JS
Charts:   Chart.js 4.4.0 (CDN — hanya halaman SKM & Ekspor)
Icons:    Font Awesome 6.4 (CDN)
Fonts:    Google Fonts — Inter
Export:   maatwebsite/laravel-excel + barryvdh/laravel-dompdf
```

---

## Struktur Folder

```
OneTouch/
│
├── 00petunjuk/                   ← Dokumentasi developer (9 file .md)
│
├── app/
│   ├── Exports/
│   │   ├── InspeksiExport.php    ← Export inspeksi ke Excel
│   │   └── SertifikatExport.php  ← Export sertifikat ke Excel
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/            ← 5 controller panel admin
│   │   │   ├── Auth/             ← LoginController (login + logout + redirect)
│   │   │   ├── Officer/          ← 4 controller panel officer
│   │   │   ├── Public/           ← 8 controller portal publik
│   │   │   └── User/             ← 4 controller panel user (read-only)
│   │   ├── Kernel.php            ← Registrasi middleware alias 'role'
│   │   └── Middleware/
│   │       └── RoleMiddleware.php ← Cek role user, redirect jika salah
│   └── Models/
│       ├── User.php              ← Model users (role + relasi)
│       ├── Sertifikat.php        ← Model sertifikats
│       ├── Inspeksi.php          ← Model inspeksis
│       ├── DataSkm.php           ← Model data_skms
│       └── DataEkspor.php        ← Model data_ekspors
│
├── database/
│   ├── migrations/               ← 8 file definisi struktur tabel
│   ├── seeders/
│   │   └── DatabaseSeeder.php    ← Kosong (data sudah ada)
│   └── onetouch.sql              ← ⭐ Export lengkap database (import ini)
│
├── resources/views/
│   ├── layouts/
│   │   ├── public.blade.php      ← Master layout portal publik
│   │   └── internal.blade.php    ← Master layout sistem internal
│   ├── auth/login.blade.php      ← Halaman login
│   ├── public/                   ← 8 view halaman publik
│   ├── admin/                    ← View panel admin (dashboard + 4 entity)
│   ├── officer/                  ← View panel officer
│   ├── user/                     ← View panel user (read-only)
│   └── pdf/                      ← Template PDF laporan
│
├── routes/web.php                ← ⭐ SEMUA route aplikasi
├── DEMO-ACCOUNTS.md              ← Akun demo & kredensial
└── .env                          ← Konfigurasi environment
```

---

## Database & Tabel

### Skema Relasi

```
users
 ├─── id ◄─── sertifikats.user_id    (sertifikat milik siapa)
 ├─── id ◄─── sertifikats.created_by (officer yang input)
 ├─── id ◄─── inspeksis.user_id      (inspeksi milik siapa)
 ├─── id ◄─── inspeksis.created_by   (officer yang input)
 └─── id ◄─── users.officer_id       (self-join: officer handle user)

data_skms    ← Berdiri sendiri (data SKM per tahun)
data_ekspors ← Berdiri sendiri (data ekspor per bulan per tahun)
```

### Ringkasan Tabel

| Tabel | Kolom Kunci | Keterangan |
|-------|------------|------------|
| `users` | `role` enum, `officer_id` FK | 3 role: admin/officer/user |
| `sertifikats` | `user_id`, `created_by`, `jenis_sertifikat` enum, `status_masa` enum | 10 jenis sertifikat |
| `inspeksis` | `user_id`, `created_by`, `kategori` enum | Inspeksi/Surveilan |
| `data_skms` | `tahun`, `target`, `realisasi` | Skala 1–5 |
| `data_ekspors` | `bulan`, `tahun`, `frekuensi`, `volume`, `nilai` | Per bulan per tahun |

---

## Alur Request

```
Browser
  └─► public/index.php                  Entry point Laravel
        └─► app/Http/Kernel.php          Global middleware stack
              └─► routes/web.php         Match URL ke route
                    └─► [middleware]     auth, role:xxx
                          └─► Controller@method()
                                └─► view('...')
                                      └─► layouts/{public|internal}.blade.php
                                            └─► @yield('content')  ← HTML halaman
```

### Contoh Spesifik

| URL | Route di web.php | Controller | View |
|-----|-----------------|------------|------|
| `GET /` | baris 9 | `Public\BerandaController@index` | `public.beranda` |
| `GET /skm` | baris 11 | `Public\SkmController@index` | `public.skm` |
| `POST /login` | baris 24 | `Auth\LoginController@login` | redirect |
| `GET /admin/sertifikat` | baris 36 | `Admin\SertifikatController@index` | `admin.sertifikat.index` |
| `GET /officer/inspeksi` | baris 68 | `Officer\InspeksiController@index` | `officer.inspeksi.index` |
| `GET /user/sertifikat` | baris 92 | `User\SertifikatController@index` | `user.sertifikat.index` |

---

## Hubungan Antar File

### Kode yang Saling Terhubung

#### 1. Route → Controller → View (Public SKM)

```
routes/web.php (baris 11)
  Route::get('/skm', [SkmController::class, 'index'])->name('skm')
    │
    ▼
app/Http/Controllers/Public/SkmController.php (baris 10-13)
  $skmData = DataSkm::orderBy('tahun')->get();
  return view('public.skm', compact('skmData'));
    │
    ├── app/Models/DataSkm.php → tabel 'data_skms'
    │
    ▼
resources/views/public/skm.blade.php
  @extends('layouts.public')          ← terhubung ke layouts/public.blade.php
  @foreach($skmData as $skm)          ← variabel dari controller
  @json($skmData->pluck('tahun'))     ← data ke Chart.js
```

#### 2. Middleware Chain (Route Admin)

```
routes/web.php (baris 31)
  middleware(['auth', 'role:admin'])
    │
    ├── 'auth' → app/Http/Middleware/Authenticate.php
    │     └── Jika belum login → redirect('/login')
    │
    └── 'role:admin' → app/Http/Middleware/RoleMiddleware.php
          └── Cek users.role === 'admin'
                Jika bukan → redirect ke dashboard role yang sesuai
```

#### 3. Layout → Halaman → @yield / @stack

```
layouts/public.blade.php
  @stack('styles')    ← diisi oleh @push('styles') di halaman anak
  @yield('content')  ← diisi oleh @section('content') di halaman anak
  @stack('scripts')  ← diisi oleh @push('scripts') di halaman anak

Contoh: public/ekspor.blade.php
  @extends('layouts.public')          ← parent
  @push('styles') ... @endpush        ← inject ke @stack('styles')
  @section('content') ... @endsection ← inject ke @yield('content')
  @push('scripts') ... @endpush       ← inject ke @stack('scripts')
```

#### 4. Controller → Model → Database

```
Admin\SertifikatController.php
  Sertifikat::with('user')->latest()->paginate(15)
    │
    ├── app/Models/Sertifikat.php
    │     $fillable = ['user_id', 'created_by', ...]
    │     user(): BelongsTo → User::class (FK: user_id)
    │     creator(): BelongsTo → User::class (FK: created_by)
    │
    └── Database: tabel 'sertifikats' JOIN 'users'
```

#### 5. Export PDF

```
Admin\LaporanController.php
  PDF::loadView('pdf.laporan-sertifikat', compact('sertifikats'))
    │
    └── resources/views/pdf/laporan-sertifikat.blade.php
          (HTML template → dirender oleh barryvdh/dompdf → file .pdf)
```

#### 6. Dark Mode — CSS & JS Connection

```
layouts/public.blade.php
  CSS (baris ~22):   body.dark-mode { --surface: #1e293b; ... }
  JS  (baris ~221):  document.body.classList.add('dark-mode')  ← HARUS COCOK
  localStorage key:  'onetouchTheme'

layouts/internal.blade.php
  CSS (baris ~XX):   html.dark { --surface: #1e293b; ... }
  JS  (baris ~YY):   document.documentElement.className = 'dark'  ← HARUS COCOK
  localStorage key:  'theme'
```

---

## Sistem Autentikasi & Role

### Login Flow

```
POST /login
  └─► LoginController@login()
        ├─► Auth::attempt(['username' => $username, 'password' => $password])
        └─► Redirect berdasarkan role:
              admin   → /admin/dashboard
              officer → /officer/dashboard
              user    → /user/dashboard
```

### Registrasi Middleware (Kernel.php)

```php
'role' => \App\Http\Middleware\RoleMiddleware::class
```

### File yang Terlibat

| File | Fungsi |
|------|--------|
| `app/Http/Kernel.php` | Daftarkan alias `'role'` → RoleMiddleware |
| `app/Http/Middleware/RoleMiddleware.php` | Cek `auth()->user()->role` vs parameter |
| `app/Http/Middleware/Authenticate.php` | Redirect ke `/login` jika belum auth |
| `app/Http/Middleware/RedirectIfAuthenticated.php` | Redirect dari `/login` jika sudah auth |
| `app/Http/Controllers/Auth/LoginController.php` | Proses login, logout, redirect per-role |
| `resources/views/auth/login.blade.php` | Form login (standalone, tanpa layout) |

---

## Portal Publik (8 Halaman)

Semua halaman menggunakan `@extends('layouts.public')`, tidak memerlukan login.

| URL | Controller (Public/) | View (public/) | Data dari DB |
|-----|---------------------|----------------|--------------|
| `/` | BerandaController | beranda | Statistik publik |
| `/layanan` | LayananController | layanan | Tidak ada (statis) |
| `/skm` | SkmController | skm | `DataSkm::orderBy('tahun')` → `$skmData` |
| `/ekspor` | EksporController | ekspor | `DataEkspor::all()` → `$eksporData`, `$years` |
| `/media` | MediaController | media | Tidak ada (statis) |
| `/aplikasi` | AplikasiController | aplikasi | Tidak ada (statis) |
| `/regulasi` | RegulasiController | regulasi | Tidak ada (statis) |
| `/tentang-kami` | TentangKamiController | tentang-kami | Tidak ada (statis) |

### Halaman dengan Chart.js

**SKM** (`/skm`) — Bar chart Target vs Realisasi:
```javascript
// skm.blade.php @push('scripts')
const labels    = @json($skmData->pluck('tahun'));
const targets   = @json($skmData->pluck('target'));
const realisasi = @json($skmData->pluck('realisasi'));
new Chart(document.getElementById('skmChart'), { type: 'bar', ... });
```

**Ekspor** (`/ekspor`) — 3 Line charts (Frekuensi, Volume, Nilai) dengan year filter:
```javascript
// ekspor.blade.php @push('scripts')
const eksporAll = @json($eksporData); // semua data
const years = @json($years);          // daftar tahun
// Filter client-side: eksporAll.filter(r => r.tahun == selectedYear)
```

---

## Sistem Internal (3 Panel)

Semua menggunakan `@extends('layouts.internal')`.

### Panel Admin (`/admin/*`) — Middleware: `['auth', 'role:admin']`

| Fitur | Routes | Controller |
|-------|--------|------------|
| Dashboard | `GET /admin/dashboard` | `Admin\DashboardController` |
| Sertifikat CRUD | Resource `/admin/sertifikat` | `Admin\SertifikatController` |
| Inspeksi CRUD | Resource `/admin/inspeksi` | `Admin\InspeksiController` |
| User CRUD | Resource `/admin/users` | `Admin\UserController` |
| Assign Officer | `POST /admin/users/{id}/assign-officer` | `Admin\UserController@assignOfficer` |
| Laporan | `GET /admin/laporan` | `Admin\LaporanController` |
| Export PDF/Excel | `/admin/laporan/{entity}/{format}` | `Admin\LaporanController` |

### Panel Officer (`/officer/*`) — Middleware: `['auth', 'role:officer']`

| Fitur | Scope Data |
|-------|-----------|
| Sertifikat CRUD | `WHERE created_by = auth()->id()` |
| Inspeksi CRUD | `WHERE created_by = auth()->id()` |
| Laporan + Export | Data yang officer ini input |

### Panel User (`/user/*`) — Middleware: `['auth', 'role:user']`

| Fitur | Scope Data |
|-------|-----------|
| Sertifikat (read-only) | `WHERE user_id = auth()->id()` |
| Inspeksi (read-only) | `WHERE user_id = auth()->id()` |
| Laporan + Export | Data milik sendiri |

---

## Dark / Light Mode

| | Portal Publik | Sistem Internal |
|--|--------------|----------------|
| **Layout** | `layouts/public.blade.php` | `layouts/internal.blade.php` |
| **localStorage key** | `onetouchTheme` | `theme` |
| **CSS selector** | `body.dark-mode { }` | `html.dark { }` |
| **JS target** | `document.body.classList` | `document.documentElement.className` |

**Warna CSS Variables:**

| Variable | Light | Dark |
|----------|-------|------|
| `--surface` | `#ffffff` | `#1e293b` |
| `--surface-2` | `#f8fafc` | `#0f172a` |
| `--border` | `#e2e8f0` | `#334155` |
| `--text` | `#1e293b` | `#f1f5f9` |

---

## Akun Demo

> Lihat detail lengkap di `DEMO-ACCOUNTS.md`

| Role | Username | Password | Redirect |
|------|----------|----------|----------|
| Admin | `admin` | `password123` | `/admin/dashboard` |
| Officer A | `officer` | `password123` | `/officer/dashboard` |
| Officer B | `officer2` | `password123` | `/officer/dashboard` |
| User 1 | `user` | `password123` | `/user/dashboard` |
| User 2 | `user2` | `password123` | `/user/dashboard` |

---

## Instalasi

```bash
# 1. Install dependencies
composer install

# 2. Konfigurasi environment
cp .env.example .env
php artisan key:generate

# 3. Isi database credentials di .env
DB_CONNECTION=mysql
DB_DATABASE=onetouch
DB_USERNAME=root
DB_PASSWORD=

# 4. Buat database & import
mysql -u root -e "CREATE DATABASE onetouch CHARACTER SET utf8mb4;"
mysql -u root onetouch < database/onetouch.sql

# 5. Akses aplikasi
# Via Laragon: http://localhost/OneTouch/public
# Via artisan:  php artisan serve → http://localhost:8000
```

---

## Export PDF & Excel

### PDF — `barryvdh/laravel-dompdf`

```php
// Di LaporanController
$pdf = PDF::loadView('pdf.laporan-sertifikat', compact('sertifikats'))
          ->setPaper('a4', 'landscape');
return $pdf->download('laporan.pdf');
```

Template: `resources/views/pdf/laporan-sertifikat.blade.php`

### Excel — `maatwebsite/laravel-excel`

```php
// Di LaporanController
return Excel::download(new SertifikatExport($filters), 'laporan.xlsx');
```

Export class: `app/Exports/SertifikatExport.php`

---

## Dokumentasi Developer

Untuk dokumentasi lebih detail, lihat folder `00petunjuk/`:

| File | Isi |
|------|-----|
| `01-overview.md` | Project overview, tech stack, URL structure |
| `02-struktur-folder.md` | Peta lengkap semua folder & file |
| `03-alur-request.md` | Alur request dari browser ke response |
| `04-autentikasi-dan-role.md` | Login, middleware, RBAC |
| `05-public-portal.md` | 8 halaman publik detail |
| `06-sistem-internal.md` | Admin/Officer/User panel |
| `07-database-dan-model.md` | Semua tabel, kolom, relasi |
| `08-tema-dan-styling.md` | Dark/light mode, CSS variables |
| `09-panduan-development.md` | Cara tambah fitur, konvensi, deploy checklist |

---

*Sistem ONE TOUCH — Balai PPMHKP Lampung, Kementerian Kelautan dan Perikanan*
