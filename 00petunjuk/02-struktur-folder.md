# 02 — Struktur Folder & Fungsi Setiap File

## Peta Folder Lengkap

```
OneTouch/
│
├── 00petunjuk/                  ← Dokumentasi developer (folder ini)
│   ├── 01-overview.md
│   ├── 02-struktur-folder.md
│   ├── 03-alur-request.md
│   ├── 04-autentikasi-dan-role.md
│   ├── 05-public-portal.md
│   ├── 06-sistem-internal.md
│   ├── 07-database-dan-model.md
│   ├── 08-tema-dan-styling.md
│   └── 09-panduan-development.md
│
├── app/
│   ├── Exports/                 ← Kelas export Excel (maatwebsite)
│   │   ├── InspeksiExport.php   ← Export data inspeksi ke .xlsx
│   │   └── SertifikatExport.php ← Export data sertifikat ke .xlsx
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php   ← Base controller (abstract)
│   │   │   ├── Admin/           ← Controller panel Admin
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── InspeksiController.php
│   │   │   │   ├── LaporanController.php
│   │   │   │   ├── SertifikatController.php
│   │   │   │   └── UserController.php
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php  ← Login + Logout + redirect per-role
│   │   │   ├── Officer/         ← Controller panel Officer
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── InspeksiController.php
│   │   │   │   ├── LaporanController.php
│   │   │   │   └── SertifikatController.php
│   │   │   ├── Public/          ← Controller portal publik
│   │   │   │   ├── AplikasiController.php
│   │   │   │   ├── BerandaController.php
│   │   │   │   ├── EksporController.php
│   │   │   │   ├── LayananController.php
│   │   │   │   ├── MediaController.php
│   │   │   │   ├── RegulasiController.php
│   │   │   │   ├── SkmController.php
│   │   │   │   └── TentangKamiController.php
│   │   │   └── User/            ← Controller panel User (read-only)
│   │   │       ├── DashboardController.php
│   │   │       ├── InspeksiController.php
│   │   │       ├── LaporanController.php
│   │   │       └── SertifikatController.php
│   │   │
│   │   ├── Kernel.php           ← Registrasi middleware (termasuk 'role')
│   │   └── Middleware/
│   │       ├── Authenticate.php          ← Redirect ke login jika belum auth
│   │       ├── RedirectIfAuthenticated.php ← Redirect ke dashboard jika sudah auth
│   │       ├── RoleMiddleware.php        ← Cek role user (admin/officer/user)
│   │       └── ... (middleware bawaan Laravel)
│   │
│   ├── Models/
│   │   ├── DataEkspor.php       ← Model tabel data_ekspors
│   │   ├── DataSkm.php          ← Model tabel data_skms
│   │   ├── Inspeksi.php         ← Model tabel inspeksis
│   │   ├── Sertifikat.php       ← Model tabel sertifikats
│   │   └── User.php             ← Model tabel users (dengan role + relasi)
│   │
│   └── Providers/
│       ├── AppServiceProvider.php     ← Boot aplikasi
│       ├── AuthServiceProvider.php    ← Policy & Gate
│       └── RouteServiceProvider.php   ← HOME constant = '/login'
│
├── assets/                      ← Logo & gambar (sumber asli)
│   ├── header-logo1-kkp.png
│   ├── header-logo2-bppmhkp.png
│   ├── Portal-LogoKKP-TeksPutih.png
│   ├── Portal-LogoKKPRound-Warna.png
│   ├── bg-dark.jpg
│   └── bg-light.jpg
│
├── config/
│   ├── app.php          ← Timezone (Asia/Jakarta), locale, key
│   ├── auth.php         ← Guard + provider konfigurasi
│   ├── database.php     ← Konfigurasi koneksi DB
│   └── excel.php        ← Konfigurasi maatwebsite/excel
│
├── database/
│   ├── migrations/      ← Definisi struktur tabel
│   │   ├── ..._create_users_table.php
│   │   ├── ..._create_sertifikats_table.php
│   │   ├── ..._create_inspeksis_table.php
│   │   ├── ..._create_data_skms_table.php
│   │   └── ..._create_data_ekspors_table.php
│   ├── seeders/
│   │   └── DatabaseSeeder.php   ← Kosong (data sudah ada di DB)
│   └── onetouch.sql             ← Export lengkap database (CREATE + INSERT)
│
├── public/
│   ├── index.php        ← Entry point aplikasi Laravel
│   ├── .htaccess        ← URL rewrite untuk Apache/Laragon
│   └── assets/          ← Logo & gambar yang diakses lewat web
│
├── resources/
│   ├── css/app.css      ← CSS kosong (tidak dipakai, styling ada di Blade)
│   ├── js/app.js        ← JS kosong (tidak dipakai, JS ada di Blade)
│   └── views/
│       ├── layouts/
│       │   ├── public.blade.php    ← Master layout portal publik
│       │   └── internal.blade.php  ← Master layout sistem internal
│       ├── auth/
│       │   └── login.blade.php     ← Halaman login
│       ├── public/
│       │   ├── beranda.blade.php
│       │   ├── layanan.blade.php
│       │   ├── skm.blade.php
│       │   ├── ekspor.blade.php
│       │   ├── media.blade.php
│       │   ├── aplikasi.blade.php
│       │   ├── regulasi.blade.php
│       │   └── tentang-kami.blade.php
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── sertifikat/ (index, create, edit, show)
│       │   ├── inspeksi/   (index, create, edit, show)
│       │   ├── users/      (index, create, edit, show)
│       │   └── laporan/    (index)
│       ├── officer/
│       │   ├── dashboard.blade.php
│       │   ├── sertifikat/ (index, create, edit, show)
│       │   ├── inspeksi/   (index, create, edit, show)
│       │   └── laporan/    (index)
│       ├── user/
│       │   ├── dashboard.blade.php
│       │   ├── sertifikat/ (index, show)
│       │   ├── inspeksi/   (index, show)
│       │   └── laporan/    (index)
│       └── pdf/
│           ├── laporan-sertifikat.blade.php ← Template PDF sertifikat
│           └── laporan-inspeksi.blade.php   ← Template PDF inspeksi
│
├── routes/
│   └── web.php          ← SEMUA route aplikasi (publik + auth + admin + officer + user)
│
├── .env                 ← Konfigurasi environment (DB, APP_KEY, dll) — JANGAN di-commit
├── .env.example         ← Template .env
├── composer.json        ← PHP dependencies
├── package.json         ← JS dependencies (npm)
├── DEMO-ACCOUNTS.md     ← Akun demo untuk testing
├── ONETOUCH_PROJECT_SPEC.md ← Spesifikasi proyek lengkap
└── README.md            ← Dokumentasi utama
```

---

## Penjelasan File Kritis

### `routes/web.php`
**File terpenting** — mendefinisikan semua URL aplikasi. Dibagi 4 section:
1. **Public** (baris ~5–14) — 8 route tanpa auth
2. **Auth** (baris ~19–26) — login/logout
3. **Admin** (baris ~31–58) — prefix `/admin`, middleware `role:admin`
4. **Officer** (baris ~63–82) — prefix `/officer`, middleware `role:officer`
5. **User** (baris ~87–103) — prefix `/user`, middleware `role:user`

### `app/Http/Kernel.php`
Registrasi middleware alias `role` → `RoleMiddleware::class` sehingga bisa dipakai di route.

### `app/Http/Middleware/RoleMiddleware.php`
Mengecek `auth()->user()->role` vs parameter yang diminta. Jika tidak sesuai → redirect ke dashboard masing-masing atau login.

### `resources/views/layouts/public.blade.php`
Layout master untuk semua 8 halaman publik. Berisi:
- CSS Variables (`:root` + `body.dark-mode`)
- Header dengan logo + tombol dark mode + tombol login
- Navbar 8 link
- `@yield('content')` — konten halaman
- Footer
- JS dark mode toggle (localStorage key: `onetouchTheme`)

### `resources/views/layouts/internal.blade.php`
Layout master untuk semua halaman internal (admin/officer/user). Berisi:
- CSS Variables (`:root` + `html.dark`)
- Sidebar navigasi (dinamis per role)
- Topbar dengan info user + tombol logout + dark mode
- `@yield('content')`
- JS dark mode (localStorage key: `theme`, class `dark` pada `<html>`)
