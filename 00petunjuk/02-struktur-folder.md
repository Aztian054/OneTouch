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
│   ├── 09-panduan-development.md
│   └── 10-laporan-kemajuan.md
│
├── app/
│   ├── Exports/                 ← Kelas export Excel (maatwebsite)
│   │   ├── DataEksporExport.php ← Export data ekspor ke .xlsx
│   │   ├── InspeksiExport.php   ← Export data inspeksi ke .xlsx
│   │   ├── SkmSurveyExport.php  ← Export data SKM survey ke .xlsx
│   │   ├── SertifikatExport.php ← Export data sertifikat ke .xlsx
│   │   └── UserExport.php       ← Export data user ke .xlsx
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php   ← Base controller (abstract)
│   │   │   ├── Admin/           ← Controller panel Admin
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── DataEksporController.php  ← CRUD data ekspor
│   │   │   │   ├── DataSkmController.php     ← CRUD data SKM tahunan
│   │   │   │   ├── InspeksiController.php
│   │   │   │   ├── LaporanController.php
│   │   │   │   ├── NewsController.php        ← CRUD berita/artikel
│   │   │   │   ├── PageController.php        ← CRUD halaman dinamis
│   │   │   │   ├── SkmSurveyController.php   ← CRUD SKM survey
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
│   │   ├── News.php             ← Model tabel news (berita/artikel)
│   │   ├── Page.php             ← Model tabel pages (halaman dinamis)
│   │   ├── Sertifikat.php       ← Model tabel sertifikats
│   │   ├── SkmSurvey.php        ← Model tabel skm_surveys
│   │   └── User.php             ← Model tabel users (dengan role + relasi)
│   │
│   └── Providers/
│       ├── AppServiceProvider.php     ← Boot aplikasi
│       ├── AuthServiceProvider.php    ← Policy & Gate
│       └── RouteServiceProvider.php   ← HOME constant = '/login'
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
│   │   ├── ..._create_data_ekspors_table.php
│   │   ├── ..._add_berkas_to_sertifikats_table.php
│   │   ├── ..._create_skm_surveys_table.php
│   │   ├── ..._create_pages_table.php
│   │   ├── ..._create_news_table.php
│   │   └── ..._add_fields_to_data_ekspors_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php   ← Seeder utama
│   │   └── EksporSeeder.php     ← Seeder data ekspor
│   └── onetouch.sql             ← Export lengkap database (CREATE + INSERT)
│
├── public/
│   ├── index.php        ← Entry point aplikasi Laravel
│   ├── .htaccess        ← URL rewrite untuk Apache/Laragon
│   └── assets/          ← Logo & gambar yang diakses lewat web
│       ├── header-logo1-kkp.png
│       ├── header-logo2-bppmhkp.png
│       ├── Portal-Logo-KKP-TeksHitam.png
│       ├── Portal-LogoKKP-TeksPutih.png
│       ├── Portal-LogoKKPRound-TeksPutih.png
│       ├── Portal-LogoKKPRound-Warna.png
│       ├── bg-dark.jpg
│       ├── bg-light.jpg
│       ├── news/                    ← Folder upload gambar berita
│       └── Struktur_organisasi/
│           └── S_Organisasi.jpeg
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
│       │   ├── data-ekspor/ (index, create, edit)
│       │   ├── data-skm/    (index, create, edit)
│       │   ├── news/        (index, create, edit)
│       │   ├── pages/       (index, edit)
│       │   ├── skm/         (index, edit, show)
│       │   └── laporan/     (index)
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
│           ├── data-ekspor.blade.php     ← Template PDF data ekspor
│           ├── laporan-inspeksi.blade.php ← Template PDF inspeksi
│           ├── laporan-sertifikat.blade.php ← Template PDF sertifikat
│           ├── skm-surveys.blade.php     ← Template PDF SKM survey
│           └── users.blade.php           ← Template PDF users
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
**File terpenting** — mendefinisikan semua URL aplikasi. Dibagi 5 section:
1. **Public** — 8 route tanpa auth
2. **Auth** — login/logout
3. **Admin** — prefix `/admin`, middleware `role:admin`
4. **Officer** — prefix `/officer`, middleware `role:officer`
5. **User** — prefix `/user`, middleware `role:user`

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

---

## Controllers Admin Baru

### `DataEksporController.php`
CRUD data ekspor perikanan (frekuensi, volume, nilai per bulan/tahun).

### `DataSkmController.php`
CRUD data SKM tahunan (target & realisasi IKM per tahun).

### `NewsController.php`
CRUD berita/artikel untuk halaman media publik.

### `PageController.php`
CRUD halaman dinamis (konten yang bisa diedit tanpa kode).

### `SkmSurveyController.php`
CRUD hasil survey kepuasan masyarakat (responden + jawaban Q1-Q7).

---

## Models Baru

### `News.php`
```php
protected $fillable = [
    'title', 'description', 'image', 'event_date', 'is_active', 'order'
];
```

### `Page.php`
```php
protected $fillable = [
    'slug', 'title', 'subtitle', 'content', 'hero_image',
    'meta_title', 'meta_description', 'is_active', 'order'
];
```

### `SkmSurvey.php`
```php
protected $fillable = [
    'nama', 'email', 'no_telp', 'jenis_layanan',
    'q1_kualitas_pelayanan', 'q2_kompetensi_petugas', 'q3_kecepatan',
    'q4_kenyamanan', 'q5_kenyamanan_sarpras', 'q6_fasilitas', 'q7_penampilan',
    'saran_masukan', 'ip_address', 'submitted_at', 'status'
];