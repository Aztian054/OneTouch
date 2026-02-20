# 09 — Panduan Development

## Setup Environment Dev

```bash
# Pastikan sudah ada di folder project
cd C:\laragon\www\OneTouch

# Install dependencies PHP
composer install

# Konfigurasi .env
copy .env.example .env
php artisan key:generate

# Isi DB credentials di .env:
# DB_DATABASE=onetouch
# DB_USERNAME=root
# DB_PASSWORD=

# Import database
mysql -u root onetouch < database/onetouch.sql

# Jalankan (via Laragon otomatis, atau:)
php artisan serve
```

---

## Konvensi Penamaan

### Controller
```
app/Http/Controllers/{Panel}/{Entity}Controller.php

Contoh:
  Admin/SertifikatController.php
  Officer/InspeksiController.php
  Public/BerandaController.php
  Auth/LoginController.php
```

### View
```
resources/views/{panel}/{entity}/{action}.blade.php

Contoh:
  admin/sertifikat/index.blade.php
  admin/sertifikat/create.blade.php
  officer/inspeksi/show.blade.php
  public/beranda.blade.php
  auth/login.blade.php
  pdf/laporan-sertifikat.blade.php
```

### Route Names
```
{panel}.{entity}.{action}

Contoh:
  admin.sertifikat.index
  admin.sertifikat.store
  officer.inspeksi.create
  user.laporan.index
  beranda (tanpa prefix untuk public)
```

---

## Cara Menambah Halaman Publik Baru

Misal ingin tambah halaman `/galeri`:

**1. Buat Controller:**
```bash
# Buat file: app/Http/Controllers/Public/GaleriController.php
```
```php
<?php
namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;

class GaleriController extends Controller
{
    public function index()
    {
        // query data jika perlu
        return view('public.galeri');
    }
}
```

**2. Tambah Route di `routes/web.php` (di section PUBLIC, baris ~9-14):**
```php
Route::get('/galeri', [\App\Http\Controllers\Public\GaleriController::class, 'index'])->name('galeri');
```

**3. Buat View:**
```bash
# Buat file: resources/views/public/galeri.blade.php
```
```blade
@extends('layouts.public')
@section('title', 'Galeri')

@section('content')
<section class="section">
  <div class="container">
    <h1 class="section-title">Galeri</h1>
    <!-- konten -->
  </div>
</section>
@endsection
```

**4. Tambah link di navbar (`layouts/public.blade.php`, baris ~119-128):**
```blade
<a href="{{ route('galeri') }}"
   class="nav-link {{ request()->routeIs('galeri') ? 'active' : '' }}">
  <i class="fas fa-images"></i> Galeri
</a>
```

---

## Cara Menambah Fitur Admin Baru

Misal ingin tambah CRUD untuk `DataSkm` di panel admin:

**1. Buat Controller Resource:**
```bash
php artisan make:controller Admin/DataSkmController --resource
```

**2. Tambah Route di `routes/web.php` (di section ADMIN, baris ~31-58):**
```php
Route::resource('data-skm', \App\Http\Controllers\Admin\DataSkmController::class);
```

**3. Isi method controller:**
```php
public function index() {
    $items = DataSkm::orderBy('tahun')->get();
    return view('admin.data-skm.index', compact('items'));
}

public function store(Request $request) {
    $request->validate([
        'tahun'     => 'required|digits:4',
        'target'    => 'required|numeric|between:0,5',
        'realisasi' => 'required|numeric|between:0,5',
    ]);
    DataSkm::create($request->only('tahun', 'target', 'realisasi'));
    return redirect()->route('admin.data-skm.index')
                     ->with('success', 'Data SKM berhasil ditambahkan');
}
```

**4. Buat Views:**
```
resources/views/admin/data-skm/
  index.blade.php
  create.blade.php
  edit.blade.php
```

---

## Cara Menambah Kolom Tabel Database

**1. Buat migration baru:**
```bash
php artisan make:migration add_keterangan_to_sertifikats_table
```

**2. Isi migration:**
```php
public function up(): void
{
    Schema::table('sertifikats', function (Blueprint $table) {
        $table->text('keterangan')->nullable()->after('status_proses');
    });
}

public function down(): void
{
    Schema::table('sertifikats', function (Blueprint $table) {
        $table->dropColumn('keterangan');
    });
}
```

**3. Jalankan migration:**
```bash
php artisan migrate
```

**4. Update `$fillable` di Model:**
```php
// app/Models/Sertifikat.php
protected $fillable = [
    // ...existing...
    'keterangan',  // tambahkan di sini
];
```

**5. Update SQL export:**
```bash
# Export ulang database
mysqldump -u root onetouch > database/onetouch.sql
```

---

## Cara Menambah Export Excel Baru

**1. Buat Export class:**
```bash
php artisan make:export DataSkmExport --model=DataSkm
```

**2. Implementasi di `app/Exports/DataSkmExport.php`:**
```php
class DataSkmExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return DataSkm::orderBy('tahun')->get();
    }

    public function headings(): array
    {
        return ['Tahun', 'Target IKM', 'Realisasi IKM'];
    }

    public function map($row): array
    {
        return [
            $row->tahun,
            $row->target,
            $row->realisasi,
        ];
    }
}
```

**3. Pakai di Controller:**
```php
use App\Exports\DataSkmExport;
use Maatwebsite\Excel\Facades\Excel;

public function skmExcel()
{
    return Excel::download(new DataSkmExport(), 'data-skm.xlsx');
}
```

---

## Cara Menambah Role Baru

Jika perlu tambah role `supervisor`:

**1. Update migration (atau buat migration alter):**
```php
// Alter enum
DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','officer','user','supervisor') DEFAULT 'user'");
```

**2. Buat folder Controller:**
```
app/Http/Controllers/Supervisor/
```

**3. Tambah route group di `routes/web.php`:**
```php
Route::prefix('supervisor')->name('supervisor.')->middleware(['auth', 'role:supervisor'])->group(function () {
    Route::get('/dashboard', [...])->name('dashboard');
});
```

**4. Update `RoleMiddleware.php` untuk handle redirect:**
```php
return match(auth()->user()->role) {
    'admin'      => redirect()->route('admin.dashboard'),
    'officer'    => redirect()->route('officer.dashboard'),
    'supervisor' => redirect()->route('supervisor.dashboard'),  // tambahkan
    default      => redirect()->route('user.dashboard'),
};
```

**5. Update `LoginController.php` redirect setelah login.**

---

## Checklist Sebelum Deploy ke Production

- [ ] Ubah `APP_ENV=production` di `.env`
- [ ] Ubah `APP_DEBUG=false` di `.env`
- [ ] Set `APP_URL` ke URL production
- [ ] Ganti semua password demo (lihat `DEMO-ACCOUNTS.md`)
- [ ] Jalankan `php artisan config:cache`
- [ ] Jalankan `php artisan route:cache`
- [ ] Jalankan `php artisan view:cache`
- [ ] Pastikan `storage/` dan `bootstrap/cache/` writable
- [ ] Update `database/onetouch.sql` dengan export terbaru
- [ ] Hapus file `00petunjuk/` dari server production (opsional)

---

## Troubleshooting Umum

### Error: View not found
```
View [public.skm] not found
```
**Solusi:** Pastikan file ada di `resources/views/public/skm.blade.php`

### Error: Undefined variable $skmData
```
Undefined variable $skmData
```
**Solusi:** Cek nama variable di Controller (`compact('skmData')`) harus sama dengan yang dipakai di view (`$skmData`).

### Error: Route not defined
```
Route [admin.sertifikat.index] not defined
```
**Solusi:** Cek `routes/web.php` — pastikan route ada dan nama prefix-nya benar.

### Error: CSRF Token Mismatch
```
419 | Page Expired
```
**Solusi:** Pastikan ada `@csrf` di dalam `<form>` setiap form POST.

### Dark mode tidak bekerja
**Solusi:** Cek apakah CSS selector cocok dengan class yang ditambahkan JS:
- Public: CSS `body.dark-mode`, JS: `document.body.classList.add('dark-mode')`  ✓
- Internal: CSS `html.dark`, JS: `document.documentElement.className = 'dark'`  ✓
