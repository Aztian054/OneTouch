# 07 — Database & Model

## Daftar Tabel

| Tabel                    | Model              | Keterangan                              |
|--------------------------|--------------------|-----------------------------------------|
| `users`                  | `User`             | Semua pengguna sistem (3 role)          |
| `sertifikats`            | `Sertifikat`       | Data sertifikat hasil perikanan         |
| `inspeksis`              | `Inspeksi`         | Data kunjungan inspeksi/surveilan       |
| `data_skms`              | `DataSkm`          | Data Survey Kepuasan Masyarakat per tahun |
| `data_ekspors`           | `DataEkspor`       | Data ekspor per bulan per tahun         |
| `news`                   | `News`             | Berita dan artikel                      |
| `pages`                  | `Page`             | Halaman dinamis (konten editable)       |
| `skm_surveys`            | `SkmSurvey`        | Hasil survey kepuasan masyarakat        |
| `password_reset_tokens`  | —                  | Laravel default                         |
| `personal_access_tokens` | —                  | Laravel Sanctum                         |
| `failed_jobs`            | —                  | Laravel queue                           |
| `migrations`             | —                  | Laravel migration history               |

---

## Diagram Relasi

```
users
 ├─ id ◄──────────────── sertifikats.user_id (pemilik)
 │                        sertifikats.created_by (officer yang input)
 │
 ├─ id ◄──────────────── inspeksis.user_id (pemilik)
 │                        inspeksis.created_by (officer yang input)
 │
 └─ id ◄──────────────── users.officer_id (self-referential: officer → user)


data_skms      ← Tidak ada relasi ke tabel lain
data_ekspors   ← Tidak ada relasi ke tabel lain
news           ← Tidak ada relasi ke tabel lain
pages          ← Tidak ada relasi ke tabel lain
skm_surveys    ← Tidak ada relasi ke tabel lain
```

---

## Detail Tabel & Kolom

### Tabel `users`
**Migration:** `database/migrations/2014_10_12_000000_create_users_table.php`
**Model:** `app/Models/User.php`

| Kolom          | Tipe                          | Nullable | Keterangan                        |
|----------------|-------------------------------|----------|-----------------------------------|
| `id`           | bigint UNSIGNED AUTO_INCREMENT | —       | Primary key                       |
| `name`         | varchar(255)                  | NO       | Nama lengkap / nama perusahaan    |
| `username`     | varchar(255) UNIQUE           | NO       | Digunakan untuk login             |
| `email`        | varchar(255) UNIQUE           | YES      | Email (opsional)                  |
| `email_verified_at` | timestamp              | YES      | Laravel default                   |
| `password`     | varchar(255)                  | NO       | Bcrypt hash                       |
| `role`         | enum('admin','officer','user') | NO      | Default: 'user'                   |
| `company_name` | varchar(255)                  | YES      | Nama perusahaan (untuk role user) |
| `officer_id`   | bigint UNSIGNED               | YES      | FK → users.id (officer pembimbing)|
| `remember_token` | varchar(100)                | YES      | Laravel remember me               |
| `created_at`   | timestamp                     | YES      | —                                 |
| `updated_at`   | timestamp                     | YES      | —                                 |

**Relasi di Model `User.php`:**
```php
// Sertifikat yang dimiliki user ini
public function sertifikats(): HasMany
{
    return $this->hasMany(Sertifikat::class, 'user_id');
}

// Inspeksi yang dimiliki user ini
public function inspeksis(): HasMany
{
    return $this->hasMany(Inspeksi::class, 'user_id');
}

// Officer yang handle user ini (self-join)
public function officer(): BelongsTo
{
    return $this->belongsTo(User::class, 'officer_id');
}

// User-user yang di-handle officer ini
public function handledUsers(): HasMany
{
    return $this->hasMany(User::class, 'officer_id');
}
```

---

### Tabel `sertifikats`
**Migration:** `database/migrations/2024_01_01_000001_create_sertifikats_table.php`
**Model:** `app/Models/Sertifikat.php`

| Kolom               | Tipe                              | Nullable | Keterangan                     |
|---------------------|-----------------------------------|----------|--------------------------------|
| `id`                | bigint UNSIGNED AUTO_INCREMENT    | —        | Primary key                    |
| `user_id`           | bigint UNSIGNED                   | NO       | FK → users.id (pemilik)        |
| `created_by`        | bigint UNSIGNED                   | YES      | FK → users.id (officer input)  |
| `nama_pemilik`      | varchar(255)                      | NO       | Nama pemilik sertifikat        |
| `nomor_sertifikat`  | varchar(255)                      | NO       | Nomor sertifikat unik          |
| `ruang_lingkup`     | varchar(255)                      | NO       | Ruang lingkup sertifikasi      |
| `jenis_sertifikat`  | enum(...)                         | NO       | Jenis sertifikat (lihat bawah) |
| `grade`             | enum('A','B','C')                 | NO       | Default: 'A'                   |
| `tanggal_terbit`    | date                              | NO       | Tanggal sertifikat diterbitkan |
| `tanggal_kadaluwarsa` | date                            | NO       | Tanggal kadaluwarsa            |
| `status_masa`       | enum('aktif','warning','expired') | NO       | Default: 'aktif'               |
| `status_proses`     | enum('Pending','Process','Completed') | NO   | Default: 'Pending'             |
| `created_at`        | timestamp                         | YES      | —                              |
| `updated_at`        | timestamp                         | YES      | —                              |

**Nilai enum `jenis_sertifikat`:**
`HACCP`, `SKP`, `SPDI`, `HC`, `CBIB`, `CPIB`, `CPIB Kapal`, `CPPIB`, `CPOIB`, `CDOIB`

**Relasi di Model `Sertifikat.php`:**
```php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}

public function creator(): BelongsTo
{
    return $this->belongsTo(User::class, 'created_by');
}
```

---

### Tabel `inspeksis`
**Migration:** `database/migrations/2024_01_01_000002_create_inspeksis_table.php`
**Model:** `app/Models/Inspeksi.php`

| Kolom             | Tipe                                 | Nullable | Keterangan                    |
|-------------------|--------------------------------------|----------|-------------------------------|
| `id`              | bigint UNSIGNED AUTO_INCREMENT       | —        | Primary key                   |
| `user_id`         | bigint UNSIGNED                      | NO       | FK → users.id (pemilik)       |
| `created_by`      | bigint UNSIGNED                      | YES      | FK → users.id (officer input) |
| `nama_perusahaan` | varchar(255)                         | NO       | Nama perusahaan yang diinspeksi |
| `tanggal`         | date                                 | NO       | Tanggal inspeksi              |
| `kategori`        | enum('Inspeksi','Surveilan')         | NO       | Jenis kunjungan               |
| `jenis_sertifikat`| enum(...)                            | NO       | Sama dengan tabel sertifikats |
| `berkas_path`     | varchar(500)                         | YES      | Path file berkas (upload)     |
| `status_berkas`   | enum('Terkirim','Tidak Ada')         | NO       | Default: 'Tidak Ada'          |
| `created_at`      | timestamp                            | YES      | —                             |
| `updated_at`      | timestamp                            | YES      | —                             |

**Relasi di Model `Inspeksi.php`:**
```php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}

public function creator(): BelongsTo
{
    return $this->belongsTo(User::class, 'created_by');
}
```

---

### Tabel `data_skms`
**Migration:** `database/migrations/2024_01_01_000003_create_data_skms_table.php`
**Model:** `app/Models/DataSkm.php`

| Kolom        | Tipe                           | Nullable | Keterangan            |
|--------------|--------------------------------|----------|-----------------------|
| `id`         | bigint UNSIGNED AUTO_INCREMENT | —        | Primary key           |
| `tahun`      | year(4)                        | NO       | Tahun survei (misal: 2024) |
| `target`     | decimal(5,2)                   | NO       | Target IKM (skala 1–5) |
| `realisasi`  | decimal(5,2)                   | NO       | Realisasi IKM (skala 1–5) |
| `created_at` | timestamp                      | YES      | —                     |
| `updated_at` | timestamp                      | YES      | —                     |

**Contoh Data:**
```
tahun | target | realisasi
------+--------+----------
2020  |  3.50  |  3.65
2021  |  3.60  |  3.71
2022  |  3.70  |  3.85
2023  |  3.80  |  3.92
2024  |  3.90  |  4.01
```

---

### Tabel `data_ekspors`
**Migration:** `database/migrations/2024_01_01_000004_create_data_ekspors_table.php`
**Model:** `app/Models/DataEkspor.php`

| Kolom        | Tipe                           | Nullable | Keterangan                |
|--------------|--------------------------------|----------|---------------------------|
| `id`         | bigint UNSIGNED AUTO_INCREMENT | —        | Primary key               |
| `bulan`      | tinyint(3) UNSIGNED            | NO       | Bulan (1–12)              |
| `tahun`      | year(4)                        | NO       | Tahun                     |
| `frekuensi`  | int(11)                        | NO       | Jumlah pengiriman         |
| `volume`     | decimal(12,2)                  | NO       | Volume dalam Ton          |
| `nilai`      | decimal(15,2)                  | NO       | Nilai ekspor dalam USD    |
| `created_at` | timestamp                      | YES      | —                         |
| `updated_at` | timestamp                      | YES      | —                         |

---

### Tabel `news` (Baru)
**Migration:** `database/migrations/2026_02_20_041535_create_news_table.php`
**Model:** `app/Models/News.php`

| Kolom        | Tipe                           | Nullable | Keterangan                |
|--------------|--------------------------------|----------|---------------------------|
| `id`         | bigint UNSIGNED AUTO_INCREMENT | —        | Primary key               |
| `title`      | varchar(255)                   | NO       | Judul berita              |
| `description`| text                           | YES      | Isi/deskripsi berita      |
| `image`      | varchar(255)                   | YES      | Path gambar berita        |
| `event_date` | date                           | YES      | Tanggal kejadian/berita   |
| `is_active`  | boolean                        | NO       | Status tampil/sembunyi    |
| `order`      | int(11)                        | NO       | Urutan tampil             |
| `created_at` | timestamp                      | YES      | —                         |
| `updated_at` | timestamp                      | YES      | —                         |

**Model `News.php`:**
```php
protected $fillable = [
    'title', 'description', 'image', 'event_date', 'is_active', 'order'
];

protected $casts = [
    'is_active' => 'boolean',
    'event_date' => 'date',
];

// Scopes
public function scopeActive($query) {
    return $query->where('is_active', true);
}

public function scopeOrdered($query) {
    return $query->orderBy('order', 'asc');
}

public function scopeLatest($query) {
    return $query->orderBy('event_date', 'desc')->orderBy('created_at', 'desc');
}
```

---

### Tabel `pages` (Baru)
**Migration:** `database/migrations/2026_02_20_030000_create_pages_table.php`
**Model:** `app/Models/Page.php`

| Kolom              | Tipe                           | Nullable | Keterangan                |
|--------------------|--------------------------------|----------|---------------------------|
| `id`               | bigint UNSIGNED AUTO_INCREMENT | —        | Primary key               |
| `slug`             | varchar(255) UNIQUE            | NO       | URL slug (beranda, layanan) |
| `title`            | varchar(255)                   | NO       | Judul halaman             |
| `subtitle`         | varchar(255)                   | YES      | Sub-judul/tagline         |
| `content`          | text                           | YES      | Konten HTML utama         |
| `hero_image`       | varchar(255)                   | YES      | Gambar header/banner      |
| `meta_title`       | varchar(255)                   | YES      | SEO title                 |
| `meta_description` | text                           | YES      | SEO description           |
| `is_active`        | boolean                        | NO       | Status aktif/nonaktif     |
| `order`            | int(11)                        | NO       | Urutan di menu            |
| `created_at`       | timestamp                      | YES      | —                         |
| `updated_at`       | timestamp                      | YES      | —                         |

**Model `Page.php`:**
```php
protected $fillable = [
    'slug', 'title', 'subtitle', 'content', 'hero_image',
    'meta_title', 'meta_description', 'is_active', 'order'
];

protected $casts = [
    'is_active' => 'boolean',
];
```

---

### Tabel `skm_surveys` (Baru)
**Migration:** `database/migrations/2026_02_20_023246_create_skm_surveys_table.php`
**Model:** `app/Models/SkmSurvey.php`

| Kolom                     | Tipe                           | Nullable | Keterangan                    |
|---------------------------|--------------------------------|----------|-------------------------------|
| `id`                      | bigint UNSIGNED AUTO_INCREMENT | —        | Primary key                   |
| `nama`                    | varchar(255)                   | NO       | Nama responden                |
| `email`                   | varchar(255)                   | YES      | Email responden               |
| `no_telp`                 | varchar(255)                   | YES      | Nomor telepon                 |
| `jenis_layanan`           | varchar(255)                   | YES      | Jenis layanan yang dinilai    |
| `q1_kualitas_pelayanan`   | decimal(2,1)                   | NO       | Nilai Q1 (1.0-4.0)            |
| `q2_kompetensi_petugas`   | decimal(2,1)                   | NO       | Nilai Q2 (1.0-4.0)            |
| `q3_kecepatan`            | decimal(2,1)                   | NO       | Nilai Q3 (1.0-4.0)            |
| `q4_kenyamanan`           | decimal(2,1)                   | NO       | Nilai Q4 (1.0-4.0)            |
| `q5_kenyamanan_sarpras`   | decimal(2,1)                   | NO       | Nilai Q5 (1.0-4.0)            |
| `q6_fasilitas`            | decimal(2,1)                   | NO       | Nilai Q6 (1.0-4.0)            |
| `q7_penampilan`           | decimal(2,1)                   | NO       | Nilai Q7 (1.0-4.0)            |
| `saran_masukan`           | text                           | YES      | Saran/masukan responden       |
| `ip_address`              | varchar(45)                    | YES      | IP address responden          |
| `submitted_at`            | timestamp                      | YES      | Waktu submit survey           |
| `status`                  | enum('active','archived')      | NO       | Status data                   |
| `created_at`              | timestamp                      | YES      | —                             |
| `updated_at`              | timestamp                      | YES      | —                             |

**Model `SkmSurvey.php`:**
```php
protected $fillable = [
    'nama', 'email', 'no_telp', 'jenis_layanan',
    'q1_kualitas_pelayanan', 'q2_kompetensi_petugas', 'q3_kecepatan',
    'q4_kenyamanan', 'q5_kenyamanan_sarpras', 'q6_fasilitas', 'q7_penampilan',
    'saran_masukan', 'ip_address', 'submitted_at', 'status'
];

protected $casts = [
    'submitted_at' => 'datetime',
];
```

**Pertanyaan Survey (Q1-Q7):**
1. Q1 — Kualitas Pelayanan
2. Q2 — Kompetensi Petugas
3. Q3 — Kecepatan Pelayanan
4. Q4 — Kenyamanan Pelayanan
5. Q5 — Kenyamanan Sarana & Prasarana
6. Q6 — Fasilitas
7. Q7 — Penampilan Petugas

**Nilai:** 1.0 (Tidak Puas) — 4.0 (Sangat Puas)

---

## Model Files

### `app/Models/User.php`

```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'username', 'email', 'password',
        'role', 'company_name', 'officer_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // Relasi ke sertifikats, inspeksis, officer, handledUsers
}
```

### `app/Models/Sertifikat.php`

```php
class Sertifikat extends Model
{
    protected $fillable = [
        'user_id', 'created_by', 'nama_pemilik', 'nomor_sertifikat',
        'ruang_lingkup', 'jenis_sertifikat', 'grade',
        'tanggal_terbit', 'tanggal_kadaluwarsa',
        'status_masa', 'status_proses',
    ];

    protected $casts = [
        'tanggal_terbit'      => 'date',
        'tanggal_kadaluwarsa' => 'date',
    ];
}
```

---

## Query Umum yang Sering Digunakan

```php
// Semua sertifikat aktif milik satu user
Sertifikat::where('user_id', $userId)
    ->where('status_masa', 'aktif')
    ->get();

// Sertifikat dengan eager load user (menghindari N+1)
Sertifikat::with('user')->latest()->paginate(15);

// Filter berdasarkan jenis + status
Sertifikat::when($request->jenis, fn($q) => $q->where('jenis_sertifikat', $request->jenis))
    ->when($request->status, fn($q) => $q->where('status_proses', $request->status))
    ->paginate(15);

// Data ekspor semua tahun (untuk chart public)
DataEkspor::orderBy('tahun')->orderBy('bulan')->get();

// Daftar tahun yang tersedia di data ekspor
DataEkspor::selectRaw('DISTINCT tahun')->orderBy('tahun')->pluck('tahun');

// Berita aktif terurut
News::active()->latest()->get();

// Halaman berdasarkan slug
Page::where('slug', 'beranda')->where('is_active', true)->first();

// SKM Survey aktif
SkmSurvey::where('status', 'active')->latest('submitted_at')->get();

// Rata-rata nilai IKM dari survey
SkmSurvey::where('status', 'active')
    ->selectRaw('AVG(q1_kualitas_pelayanan) as avg_q1')
    ->selectRaw('AVG(q2_kompetensi_petugas) as avg_q2')
    // ... dst
    ->first();
```

---

## Cara Import Database ke Environment Baru

```bash
# 1. Buat database baru di MySQL
mysql -u root -e "CREATE DATABASE onetouch CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 2. Import file SQL
mysql -u root onetouch < database/onetouch.sql

# 3. Atau via phpMyAdmin:
#    - Buat database 'onetouch'
#    - Import → pilih file database/onetouch.sql
```

---

## Migration Terbaru (2026)

| Migration | Deskripsi |
|-----------|-----------|
| `2026_02_20_023246_create_skm_surveys_table.php` | Tabel SKM Survey |
| `2026_02_20_030000_create_pages_table.php` | Tabel Pages/Halaman |
| `2026_02_20_040000_add_fields_to_data_ekspors_table.php` | Tambah field data ekspor |
| `2026_02_20_041535_create_news_table.php` | Tabel News/Berita |