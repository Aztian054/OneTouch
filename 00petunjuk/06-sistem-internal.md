# 06 — Sistem Internal: Admin, Officer, User

## Gambaran Umum

Sistem internal adalah bagian ONE TOUCH yang **memerlukan login**. Ada 3 panel terpisah berdasarkan role, semuanya menggunakan layout `resources/views/layouts/internal.blade.php`.

---

## Layout Master: `internal.blade.php`

**File:** `resources/views/layouts/internal.blade.php`

### Struktur HTML Layout:
```
<html class="light|dark">        ← Class dark mode pada <html>
  <head>
    CSS Variables + semua styling internal
  </head>
  <body>
    <div class="app-layout">
      <aside class="sidebar">    ← Navigasi samping
      <div class="main-content">
        <header class="topbar">  ← Header atas (user info + tombol)
        <main>
          @yield('content')      ← KONTEN HALAMAN DI SINI
        </main>
      </div>
    </div>
    JS dark mode (localStorage key: 'theme', class 'dark' pada <html>)
    @stack('scripts')
  </body>
</html>
```

### Dark Mode Internal:
```javascript
// internal.blade.php (dekat akhir file)
const saved = localStorage.getItem('theme') || 'light';
document.documentElement.className = saved;  // set pada <html>

function toggleTheme() {
  const next = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
  document.documentElement.className = next;
  localStorage.setItem('theme', next);
}
```

CSS:
```css
/* internal.blade.php */
html.dark { --surface: #1e293b; --surface-2: #0f172a; ... }
```

---

## Panel Admin (`/admin/*`)

**Middleware:** `['auth', 'role:admin']`
**Route prefix:** `admin`
**Route name prefix:** `admin.`

### Routes & Controllers

| Method | URL                          | Route Name                  | Controller@Method                  |
|--------|------------------------------|-----------------------------|------------------------------------|
| GET    | `/admin/dashboard`           | `admin.dashboard`           | Admin\DashboardController@index    |
| GET    | `/admin/sertifikat`          | `admin.sertifikat.index`    | Admin\SertifikatController@index   |
| GET    | `/admin/sertifikat/create`   | `admin.sertifikat.create`   | Admin\SertifikatController@create  |
| POST   | `/admin/sertifikat`          | `admin.sertifikat.store`    | Admin\SertifikatController@store   |
| GET    | `/admin/sertifikat/{id}`     | `admin.sertifikat.show`     | Admin\SertifikatController@show    |
| GET    | `/admin/sertifikat/{id}/edit`| `admin.sertifikat.edit`     | Admin\SertifikatController@edit    |
| PUT    | `/admin/sertifikat/{id}`     | `admin.sertifikat.update`   | Admin\SertifikatController@update  |
| DELETE | `/admin/sertifikat/{id}`     | `admin.sertifikat.destroy`  | Admin\SertifikatController@destroy |
| *(sama untuk inspeksi)* | | | |
| GET    | `/admin/users`               | `admin.users.index`         | Admin\UserController@index         |
| GET    | `/admin/users/create`        | `admin.users.create`        | Admin\UserController@create        |
| POST   | `/admin/users`               | `admin.users.store`         | Admin\UserController@store         |
| GET    | `/admin/users/{user}`        | `admin.users.show`          | Admin\UserController@show          |
| GET    | `/admin/users/{user}/edit`   | `admin.users.edit`          | Admin\UserController@edit          |
| PUT    | `/admin/users/{user}`        | `admin.users.update`        | Admin\UserController@update        |
| DELETE | `/admin/users/{user}`        | `admin.users.destroy`       | Admin\UserController@destroy       |
| POST   | `/admin/users/{user}/assign-officer` | `admin.users.assign-officer` | Admin\UserController@assignOfficer |
| GET    | `/admin/laporan`             | `admin.laporan.index`       | Admin\LaporanController@index      |
| GET    | `/admin/laporan/sertifikat/pdf` | `admin.laporan.sertifikat.pdf` | Admin\LaporanController@sertifikatPdf |
| GET    | `/admin/laporan/sertifikat/excel` | `admin.laporan.sertifikat.excel` | Admin\LaporanController@sertifikatExcel |
| GET    | `/admin/laporan/inspeksi/pdf` | `admin.laporan.inspeksi.pdf` | Admin\LaporanController@inspeksiPdf |
| GET    | `/admin/laporan/inspeksi/excel` | `admin.laporan.inspeksi.excel` | Admin\LaporanController@inspeksiExcel |

### Views Admin

```
resources/views/admin/
├── dashboard.blade.php          ← Statistik: total sertifikat, inspeksi, user, officer
├── sertifikat/
│   ├── index.blade.php          ← Tabel sertifikat + filter + pagination
│   ├── create.blade.php         ← Form tambah sertifikat
│   ├── edit.blade.php           ← Form edit sertifikat
│   └── show.blade.php           ← Detail sertifikat
├── inspeksi/
│   ├── index.blade.php          ← Tabel inspeksi + filter + pagination
│   ├── create.blade.php         ← Form tambah inspeksi
│   ├── edit.blade.php           ← Form edit inspeksi
│   └── show.blade.php           ← Detail inspeksi
├── users/
│   ├── index.blade.php          ← Tabel user + filter
│   ├── create.blade.php         ← Form tambah user
│   ├── edit.blade.php           ← Form edit user (termasuk assign officer)
│   └── show.blade.php           ← Detail user + data sertifikat/inspeksi miliknya
└── laporan/
    └── index.blade.php          ← Filter + tombol export PDF/Excel
```

---

## Panel Officer (`/officer/*`)

**Middleware:** `['auth', 'role:officer']`
**Route prefix:** `officer`
**Akses data:** Hanya data yang di-input oleh officer ini (`created_by = auth()->id()`)

### Routes & Controllers

| Method | URL                            | Route Name                    | Controller                         |
|--------|--------------------------------|-------------------------------|------------------------------------|
| GET    | `/officer/dashboard`           | `officer.dashboard`           | Officer\DashboardController@index  |
| *(Resource sertifikat sama seperti admin tapi prefix officer)* |
| *(Resource inspeksi sama seperti admin tapi prefix officer)*   |
| GET    | `/officer/laporan`             | `officer.laporan.index`       | Officer\LaporanController@index    |
| GET    | `/officer/laporan/sertifikat/pdf` | `officer.laporan.sertifikat.pdf` | Officer\LaporanController@sertifikatPdf |
| GET    | `/officer/laporan/sertifikat/excel` | `officer.laporan.sertifikat.excel` | Officer\LaporanController@sertifikatExcel |
| GET    | `/officer/laporan/inspeksi/pdf` | `officer.laporan.inspeksi.pdf` | Officer\LaporanController@inspeksiPdf |
| GET    | `/officer/laporan/inspeksi/excel` | `officer.laporan.inspeksi.excel` | Officer\LaporanController@inspeksiExcel |

### Perbedaan Officer vs Admin dalam Query

```php
// Admin SertifikatController@index — semua data
$sertifikats = Sertifikat::with('user')->latest()->paginate(15);

// Officer SertifikatController@index — hanya data yang dia buat
$sertifikats = Sertifikat::with('user')
    ->where('created_by', auth()->id())
    ->latest()
    ->paginate(15);
```

---

## Panel User (`/user/*`)

**Middleware:** `['auth', 'role:user']`
**Route prefix:** `user`
**Akses data:** Hanya data milik sendiri (`user_id = auth()->id()`), **read-only**

### Routes & Controllers

| Method | URL                          | Route Name               | Controller                       |
|--------|------------------------------|--------------------------|----------------------------------|
| GET    | `/user/dashboard`            | `user.dashboard`         | User\DashboardController@index   |
| GET    | `/user/sertifikat`           | `user.sertifikat.index`  | User\SertifikatController@index  |
| GET    | `/user/sertifikat/{id}`      | `user.sertifikat.show`   | User\SertifikatController@show   |
| GET    | `/user/inspeksi`             | `user.inspeksi.index`    | User\InspeksiController@index    |
| GET    | `/user/inspeksi/{id}`        | `user.inspeksi.show`     | User\InspeksiController@show     |
| GET    | `/user/laporan`              | `user.laporan.index`     | User\LaporanController@index     |
| GET    | `/user/laporan/sertifikat/pdf` | `user.laporan.sertifikat.pdf` | User\LaporanController@sertifikatPdf |
| GET    | `/user/laporan/sertifikat/excel` | `user.laporan.sertifikat.excel` | User\LaporanController@sertifikatExcel |

**Tidak ada** route `create`, `store`, `edit`, `update`, `destroy` untuk User.

---

## Export PDF & Excel

### PDF (barryvdh/laravel-dompdf)

```php
// LaporanController.php
use Barryvdh\DomPDF\Facade\Pdf;

public function sertifikatPdf(Request $request)
{
    $sertifikats = Sertifikat::with('user')
        ->when($request->status, fn($q) => $q->where('status_proses', $request->status))
        ->get();

    $pdf = Pdf::loadView('pdf.laporan-sertifikat', compact('sertifikats'))
              ->setPaper('a4', 'landscape');

    return $pdf->download('laporan-sertifikat-' . now()->format('Ymd') . '.pdf');
}
```

**Template PDF:** `resources/views/pdf/laporan-sertifikat.blade.php`
- HTML sederhana (tidak menggunakan layout internal)
- Tabel data dengan styling inline
- Header instansi

### Excel (maatwebsite/laravel-excel)

```php
// LaporanController.php
use App\Exports\SertifikatExport;
use Maatwebsite\Excel\Facades\Excel;

public function sertifikatExcel(Request $request)
{
    return Excel::download(
        new SertifikatExport($request->all()),
        'laporan-sertifikat-' . now()->format('Ymd') . '.xlsx'
    );
}
```

**Export class:** `app/Exports/SertifikatExport.php`
- Implements `FromCollection`, `WithHeadings`, `WithMapping`
- Menerima filter dari request

---

## Komponen UI Internal (dari `internal.blade.php`)

```css
/* CSS Variables tersedia di semua halaman internal */
:root {
  --sidebar-width: 240px;
  --navy:   #0f172a;
  --gold:   #d4af37;
  --surface:   #ffffff;      /* berubah saat dark mode */
  --surface-2: #f8fafc;      /* berubah saat dark mode */
  --border:    #e2e8f0;      /* berubah saat dark mode */
  --text:      #1e293b;      /* berubah saat dark mode */
}

html.dark {
  --surface:   #1e293b;
  --surface-2: #0f172a;
  --border:    #334155;
  --text:      #f1f5f9;
}
```

Semua view internal menggunakan class utility:
- `.card` — container dengan border + shadow
- `.btn`, `.btn-primary`, `.btn-danger` — tombol
- `.badge` — label status
- `.form-control` — input field
- `.table` — tabel data
