# 01 — Project Overview: ONE TOUCH

## Identitas Proyek

| Item           | Detail                                                    |
|----------------|-----------------------------------------------------------|
| **Nama Sistem**| ONE TOUCH                                                 |
| **Instansi**   | Balai PPMHKP Lampung — Kementerian Kelautan dan Perikanan |
| **Framework**  | Laravel 10                                                |
| **PHP**        | >= 8.1                                                    |
| **Database**   | MySQL / MariaDB                                           |
| **Frontend**   | Blade Templates + Vanilla CSS (CSS Variables) + Vanilla JS |
| **Export**     | maatwebsite/excel + barryvdh/laravel-dompdf               |

---

## Tujuan Sistem

ONE TOUCH adalah sistem layanan terpadu digital untuk Balai PPMHKP Lampung yang terdiri dari dua bagian utama:

### 1. Portal Publik (`/`)
Situs informasi yang dapat diakses masyarakat **tanpa login**:
- Informasi layanan sertifikasi
- Hasil Survey Kepuasan Masyarakat (SKM) — grafik Chart.js
- Data ekspor hasil perikanan — grafik Chart.js interaktif
- Media (galeri foto & berita)
- Aplikasi dan regulasi
- Profil instansi

### 2. Sistem Internal (`/admin`, `/officer`, `/user`)
Aplikasi manajemen internal dengan **3 role**:
- **Admin** — pengelolaan penuh semua data
- **Officer** — input dan kelola sertifikat/inspeksi
- **User** — akses read-only data milik sendiri

---

## Tech Stack Detail

```
Laravel 10
├── PHP 8.1+
├── Blade Templating Engine
├── Eloquent ORM
├── Laravel Sanctum (personal access tokens)
├── maatwebsite/laravel-excel (export Excel)
├── barryvdh/laravel-dompdf (export PDF)
└── MySQL/MariaDB

Frontend (Tanpa build tool / pure HTML+CSS+JS)
├── Google Fonts — Inter
├── Font Awesome 6.4 (CDN)
├── Chart.js 4.4.0 (CDN, hanya di halaman SKM & Ekspor)
└── CSS Custom Properties (dark/light mode)
```

---

## Fitur Utama

| Fitur                      | Admin | Officer | User | Publik |
|----------------------------|:-----:|:-------:|:----:|:------:|
| Portal publik              | ✅    | ✅      | ✅   | ✅     |
| Dark / Light mode toggle   | ✅    | ✅      | ✅   | ✅     |
| Login sistem               | ✅    | ✅      | ✅   | ❌     |
| CRUD Sertifikat            | ✅    | ✅      | ❌   | ❌     |
| CRUD Inspeksi              | ✅    | ✅      | ❌   | ❌     |
| Manajemen User             | ✅    | ❌      | ❌   | ❌     |
| Assign Officer ke User     | ✅    | ❌      | ❌   | ❌     |
| CRUD Data Ekspor           | ✅    | ❌      | ❌   | ❌     |
| CRUD Data SKM              | ✅    | ❌      | ❌   | ❌     |
| CRUD News/Berita           | ✅    | ❌      | ❌   | ❌     |
| CRUD Pages (Halaman)       | ✅    | ❌      | ❌   | ❌     |
| CRUD SKM Survey            | ✅    | ❌      | ❌   | ❌     |
| Export PDF                 | ✅    | ✅      | ✅   | ❌     |
| Export Excel               | ✅    | ✅      | ✅   | ❌     |
| Grafik SKM                 | ❌    | ❌      | ❌   | ✅     |
| Grafik Ekspor              | ❌    | ❌      | ❌   | ✅     |

---

## Cara Instalasi

```bash
# 1. Clone / copy project
cd C:\laragon\www
# (sudah ada di folder OneTouch)

# 2. Install dependencies
composer install
npm install

# 3. Environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=onetouch
DB_USERNAME=root
DB_PASSWORD=

# 5. Import database
# Buka phpMyAdmin atau jalankan:
mysql -u root onetouch < database/onetouch.sql

# 6. Link storage (jika ada upload file)
php artisan storage:link

# 7. Jalankan aplikasi
# Via Laragon: otomatis
# Via artisan:
php artisan serve
```

---

## Struktur URL

```
/ ─────────────────────── Portal publik (Beranda)
/layanan ──────────────── Portal publik (Layanan)
/skm ──────────────────── Portal publik (SKM)
/ekspor ───────────────── Portal publik (Data Ekspor)
/media ────────────────── Portal publik (Media)
/aplikasi ─────────────── Portal publik (Aplikasi)
/regulasi ─────────────── Portal publik (Regulasi)
/tentang-kami ─────────── Portal publik (Tentang Kami)
/login ────────────────── Halaman login (guest only)
/admin/dashboard ──────── Dashboard Admin
/admin/sertifikat ─────── Manajemen Sertifikat (Admin)
/admin/inspeksi ───────── Manajemen Inspeksi (Admin)
/admin/users ──────────── Manajemen User (Admin)
/admin/data-ekspor ────── Manajemen Data Ekspor (Admin)
/admin/data-skm ───────── Manajemen Data SKM (Admin)
/admin/news ───────────── Manajemen Berita (Admin)
/admin/pages ──────────── Manajemen Halaman (Admin)
/admin/skm ────────────── Manajemen SKM Survey (Admin)
/admin/laporan ────────── Laporan (Admin)
/officer/dashboard ────── Dashboard Officer
/officer/sertifikat ───── Sertifikat (Officer)
/officer/inspeksi ─────── Inspeksi (Officer)
/officer/laporan ──────── Laporan (Officer)
/user/dashboard ───────── Dashboard User
/user/sertifikat ──────── Sertifikat (User, read-only)
/user/inspeksi ────────── Inspeksi (User, read-only)
/user/laporan ─────────── Laporan (User)