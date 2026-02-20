# 04 — Autentikasi & Sistem Role

## Gambaran Umum

ONE TOUCH menggunakan Laravel's built-in session authentication dengan custom role-based access control (RBAC) menggunakan field `role` di tabel `users`.

```
users.role  ∈  { 'admin', 'officer', 'user' }
```

---

## File-file yang Terlibat

```
routes/web.php                              ← Definisi middleware per route group
app/Http/Kernel.php                         ← Registrasi alias middleware
app/Http/Middleware/RoleMiddleware.php      ← Logic cek role
app/Http/Middleware/Authenticate.php        ← Redirect jika belum login
app/Http/Middleware/RedirectIfAuthenticated.php  ← Redirect jika sudah login
app/Http/Controllers/Auth/LoginController.php   ← Handle login + logout
resources/views/auth/login.blade.php        ← Halaman form login
```

---

## 1. Registrasi Middleware

### `app/Http/Kernel.php`

Middleware `role` didaftarkan di `$routeMiddleware` (aliases):

```php
// app/Http/Kernel.php
protected $middlewareAliases = [
    'auth'       => \App\Http\Middleware\Authenticate::class,
    'guest'      => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'role'       => \App\Http\Middleware\RoleMiddleware::class,  // ← custom
    // ...
];
```

---

## 2. RoleMiddleware

### `app/Http/Middleware/RoleMiddleware.php`

```php
// Logika inti:
public function handle(Request $request, Closure $next, string $role): Response
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (auth()->user()->role !== $role) {
        // Redirect ke dashboard sesuai role yang dimiliki
        return match(auth()->user()->role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'officer' => redirect()->route('officer.dashboard'),
            'user'    => redirect()->route('user.dashboard'),
            default   => redirect()->route('login'),
        };
    }

    return $next($request);
}
```

**Penggunaan di routes/web.php:**
```php
// Baris 31-32
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Semua route admin — hanya role 'admin' yang boleh akses
});
```

---

## 3. LoginController

### `app/Http/Controllers/Auth/LoginController.php`

**Method `showLoginForm()`** — tampilkan halaman login:
```php
return view('auth.login');
```

**Method `login()`** — proses autentikasi:
```php
public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Redirect berdasarkan role
        return match(auth()->user()->role) {
            'admin'   => redirect()->intended(route('admin.dashboard')),
            'officer' => redirect()->intended(route('officer.dashboard')),
            default   => redirect()->intended(route('user.dashboard')),
        };
    }

    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ])->onlyInput('username');
}
```

**Method `logout()`:**
```php
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
}
```

---

## 4. Halaman Login

### `resources/views/auth/login.blade.php`

- Form dengan field `username` + `password`
- Action: `POST {{ route('login.submit') }}`
- Harus ada `@csrf` (baris ~dalam form)
- Menampilkan error via `$errors->get('username')`
- **Tidak** menggunakan layout — standalone page

---

## 5. Middleware Guest

### `app/Http/Middleware/RedirectIfAuthenticated.php`

Melindungi route `/login` agar tidak bisa diakses user yang sudah login:

```php
// routes/web.php baris 21-22
Route::middleware('guest')->group(function () {
    Route::get('/login', [...'showLoginForm'])->name('login');
    Route::post('/login', [...'login'])->name('login.submit');
});
```

Jika user sudah login dan coba akses `/login` → redirect ke dashboard sesuai role.

---

## 6. Alur Lengkap Login

```
1. User buka /login
   └── Middleware 'guest' → jika sudah login, redirect ke dashboard

2. User submit form (POST /login)
   └── LoginController@login():
       ├── Validasi input
       ├── Auth::attempt() → cek username + password (bcrypt)
       │   ├── GAGAL  → back()->withErrors() → tampilkan error di form
       │   └── SUKSES → session()->regenerate() (CSRF protection)
       │                 └── redirect berdasarkan role:
       │                     admin   → /admin/dashboard
       │                     officer → /officer/dashboard
       │                     user    → /user/dashboard
       └── Response
```

---

## 7. Alur Lengkap Akses Halaman Terproteksi

```
User akses /admin/sertifikat/create
  │
  ├── Middleware 'auth':
  │   ├── Belum login → redirect /login (dengan intended URL tersimpan)
  │   └── Sudah login → lanjut
  │
  ├── Middleware 'role:admin':
  │   ├── Role !== 'admin' → redirect ke dashboard role yang dimiliki
  │   └── Role === 'admin' → lanjut ke controller
  │
  └── SertifikatController@create() → tampilkan form
```

---

## 8. Tabel User & Role

### Struktur `users` table

| Kolom        | Tipe    | Keterangan                                       |
|--------------|---------|--------------------------------------------------|
| `id`         | bigint  | Primary key (auto increment)                     |
| `name`       | string  | Nama lengkap / nama perusahaan                   |
| `username`   | string  | Unique — digunakan untuk login                   |
| `email`      | string  | Nullable, unique                                 |
| `password`   | string  | Bcrypt hash                                      |
| `role`       | enum    | `admin` / `officer` / `user`                     |
| `company_name` | string | Nullable — nama perusahaan (untuk role user)    |
| `officer_id` | bigint  | FK ke `users.id` — officer yang handle user ini |

### Relasi User ↔ Officer

```
users (role=user)
    └── officer_id ──────FK──────► users (role=officer)
                                    └── id
```

Satu officer bisa menangani banyak user (one-to-many).

---

## 9. Cara Cek Auth di View

```blade
{{-- Cek apakah user login --}}
@auth
    <p>Selamat datang, {{ auth()->user()->name }}</p>
@endauth

@guest
    <a href="{{ route('login') }}">Login</a>
@endguest

{{-- Cek role spesifik --}}
@if(auth()->user()->role === 'admin')
    <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
@endif
```

---

## 10. Cara Cek Auth di Controller

```php
// Ambil user yang sedang login
$user = auth()->user();

// Cek role
if ($user->role === 'admin') { ... }

// ID user
$userId = auth()->id();

// Pastikan hanya lihat data milik sendiri (scope user)
$sertifikats = Sertifikat::where('user_id', auth()->id())->get();
```
