# 03 — Alur Request: Route → Middleware → Controller → View

## Diagram Umum

```
Browser
  │
  │  HTTP Request (GET/POST)
  ▼
public/index.php          ← Entry point Laravel
  │
  ▼
bootstrap/app.php         ← Inisialisasi aplikasi, binding kernel
  │
  ▼
app/Http/Kernel.php       ← Jalankan global middleware stack
  │  (TrimStrings, EncryptCookies, VerifyCsrfToken, dll)
  │
  ▼
routes/web.php            ← Match URL ke route definition
  │
  ├── Route middleware dijalankan (misal: 'auth', 'role:admin')
  │
  ▼
Controller@method()       ← Business logic + query database
  │
  ▼
View (Blade)              ← Render HTML + data
  │
  ▼
HTTP Response → Browser
```

---

## Alur Detail Per Skenario

### Skenario 1: Buka Halaman Beranda (`GET /`)

```
GET /
  │
  ├── routes/web.php baris 9:
  │   Route::get('/', [BerandaController::class, 'index'])->name('beranda')
  │   (Tidak ada middleware → langsung ke controller)
  │
  ├── app/Http/Controllers/Public/BerandaController.php
  │   └── method index():
  │       - Query: Sertifikat::count(), dll (statistik publik)
  │       - return view('public.beranda', compact(...))
  │
  ├── resources/views/public/beranda.blade.php
  │   └── @extends('layouts.public')
  │       └── resources/views/layouts/public.blade.php
  │           └── @yield('content') ← diisi konten beranda
  │
  └── Response: HTML lengkap
```

---

### Skenario 2: Login (`POST /login`)

```
POST /login
  │
  ├── routes/web.php baris 24:
  │   Route::post('/login', [LoginController::class, 'login'])
  │   Middleware: 'guest' (RedirectIfAuthenticated)
  │   → Jika sudah login, redirect ke dashboard masing-masing
  │
  ├── app/Http/Controllers/Auth/LoginController.php
  │   └── method login():
  │       - Validasi request (username, password)
  │       - Auth::attempt(['username' => $username, 'password' => $password])
  │       - Jika gagal → back()->withErrors()
  │       - Jika berhasil → redirect berdasarkan role:
  │           admin   → /admin/dashboard
  │           officer → /officer/dashboard
  │           user    → /user/dashboard
  │
  └── Response: Redirect
```

---

### Skenario 3: Admin Buka `/admin/sertifikat` (Resource Index)

```
GET /admin/sertifikat
  │
  ├── routes/web.php baris 36:
  │   Route::resource('sertifikat', SertifikatController::class)
  │   Middleware stack: ['auth', 'role:admin']
  │
  ├── Middleware 'auth' (app/Http/Middleware/Authenticate.php):
  │   → Cek: apakah user sudah login?
  │   → Jika tidak → redirect ke /login
  │
  ├── Middleware 'role:admin' (app/Http/Middleware/RoleMiddleware.php):
  │   → Cek: apakah auth()->user()->role === 'admin'?
  │   → Jika tidak → redirect ke dashboard sesuai role
  │
  ├── app/Http/Controllers/Admin/SertifikatController.php
  │   └── method index():
  │       - Query: Sertifikat::with('user')->latest()->paginate(15)
  │       - Filter (search, status, jenis) via request query string
  │       - return view('admin.sertifikat.index', compact('sertifikats', ...))
  │
  ├── resources/views/admin/sertifikat/index.blade.php
  │   └── @extends('layouts.internal')
  │       └── resources/views/layouts/internal.blade.php
  │           └── @yield('content') ← tabel sertifikat
  │
  └── Response: HTML halaman sertifikat admin
```

---

### Skenario 4: Admin Create Sertifikat (`POST /admin/sertifikat`)

```
POST /admin/sertifikat
  │
  ├── Middleware: ['auth', 'role:admin'] ← sama seperti di atas
  │
  ├── app/Http/Controllers/Admin/SertifikatController.php
  │   └── method store():
  │       - Validasi request
  │       - Sertifikat::create([...])
  │       - return redirect()->route('admin.sertifikat.index')
  │             ->with('success', 'Sertifikat berhasil ditambahkan')
  │
  └── Response: Redirect ke index dengan flash message
```

---

### Skenario 5: Export PDF (`GET /admin/laporan/sertifikat/pdf`)

```
GET /admin/laporan/sertifikat/pdf
  │
  ├── Middleware: ['auth', 'role:admin']
  │
  ├── app/Http/Controllers/Admin/LaporanController.php
  │   └── method sertifikatPdf():
  │       - Query: Sertifikat::with('user')->get() (+ filter)
  │       - $pdf = PDF::loadView('pdf.laporan-sertifikat', compact('sertifikats'))
  │       - return $pdf->download('laporan-sertifikat.pdf')
  │
  ├── resources/views/pdf/laporan-sertifikat.blade.php
  │   └── Template HTML sederhana untuk dompdf
  │
  └── Response: File PDF download
```

---

### Skenario 6: Buka Halaman SKM (`GET /skm`)

```
GET /skm
  │
  ├── routes/web.php baris 11:
  │   Route::get('/skm', [SkmController::class, 'index'])->name('skm')
  │
  ├── app/Http/Controllers/Public/SkmController.php
  │   └── method index():
  │       - $skmData = DataSkm::orderBy('tahun')->get()
  │       - return view('public.skm', compact('skmData'))
  │
  ├── resources/views/public/skm.blade.php
  │   ├── @extends('layouts.public')
  │   ├── Tabel data SKM dari $skmData
  │   └── @push('scripts'):
  │       - Chart.js (CDN) diload
  │       - @json($skmData->pluck('tahun')) → labels
  │       - @json($skmData->pluck('target')) → dataset Target
  │       - @json($skmData->pluck('realisasi')) → dataset Realisasi
  │       - Bar chart dirender di canvas#skmChart
  │
  └── Response: HTML dengan grafik interaktif
```

---

## Middleware Stack (Urutan Eksekusi)

```
1. TrustProxies
2. PreventRequestsDuringMaintenance
3. TrimStrings
4. ConvertEmptyStringsToNull
5. EncryptCookies
6. AddQueuedCookiesToResponse
7. StartSession
8. ShareErrorsFromSession
9. VerifyCsrfToken          ← POST request harus ada @csrf
10. SubstituteBindings      ← Route model binding
── (route-specific middleware) ──
11. Authenticate             ← 'auth' — cek login
12. RoleMiddleware           ← 'role:xxx' — cek role
```

---

## Sistem Flash Message

Controller mengirim flash message via `->with('success', 'pesan')`.
Layout internal menampilkannya di view dengan:

```blade
{{-- resources/views/layouts/internal.blade.php --}}
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif
```

---

## Route Model Binding

Laravel secara otomatis inject model dari parameter route:

```php
// routes/web.php
Route::resource('sertifikat', SertifikatController::class);

// Controller method show($sertifikat) — Laravel otomatis query
// Sertifikat::findOrFail($id) dan inject ke parameter
public function show(Sertifikat $sertifikat)
{
    return view('admin.sertifikat.show', compact('sertifikat'));
}
```
