# 05 — Portal Publik: 8 Halaman

## Gambaran Umum

Portal publik adalah bagian dari ONE TOUCH yang **tidak memerlukan login**. Terdiri dari 8 halaman yang menggunakan layout `resources/views/layouts/public.blade.php`.

---

## Hubungan File: Route → Controller → View → Variabel

| Route (web.php)    | Controller                     | View                         | Variabel yang di-pass         |
|--------------------|--------------------------------|------------------------------|-------------------------------|
| `GET /`            | Public\BerandaController       | `public.beranda`             | `$stats`, dll                 |
| `GET /layanan`     | Public\LayananController       | `public.layanan`             | —                             |
| `GET /skm`         | Public\SkmController           | `public.skm`                 | `$skmData`                    |
| `GET /ekspor`      | Public\EksporController        | `public.ekspor`              | `$eksporData`, `$years`       |
| `GET /media`       | Public\MediaController         | `public.media`               | —                             |
| `GET /aplikasi`    | Public\AplikasiController      | `public.aplikasi`            | —                             |
| `GET /regulasi`    | Public\RegulasiController      | `public.regulasi`            | —                             |
| `GET /tentang-kami`| Public\TentangKamiController   | `public.tentang-kami`        | —                             |

---

## Layout Master: `public.blade.php`

**File:** `resources/views/layouts/public.blade.php`

Semua 8 view public menggunakan:
```blade
@extends('layouts.public')
@section('title', 'Nama Halaman')
@push('styles') ... @endpush      ← CSS khusus halaman
@section('content') ... @endsection ← Konten utama
@push('scripts') ... @endpush    ← JS khusus halaman
```

### Slot yang tersedia di layout:
| Directive         | Diisi oleh     | Keterangan                     |
|-------------------|----------------|--------------------------------|
| `@yield('title')` | `@section('title')` | Judul tab browser         |
| `@yield('content')` | `@section('content')` | Konten halaman utama    |
| `@stack('styles')` | `@push('styles')` | CSS tambahan per halaman    |
| `@stack('scripts')` | `@push('scripts')` | JS tambahan per halaman   |

---

## Detail Per Halaman

### 1. Beranda (`/`)
**Controller:** `BerandaController@index`
**View:** `resources/views/public/beranda.blade.php`

Konten:
- Hero section dengan background gradient + overlay
- Statistik publik (jumlah sertifikat aktif, dll)
- Penjelasan layanan unggulan
- Link ke halaman-halaman lain

---

### 2. Layanan (`/layanan`)
**Controller:** `LayananController@index`
**View:** `resources/views/public/layanan.blade.php`

Konten:
- Grid kartu jenis-jenis sertifikasi:
  - HACCP, SKP, SPDI, HC, CBIB, CPIB, CPIB Kapal, CPPIB, CPOIB, CDOIB
- Persyaratan & prosedur masing-masing layanan
- Tidak ada data dari database — konten statis

---

### 3. SKM — Survey Kepuasan Masyarakat (`/skm`)
**Controller:** `SkmController@index`
**View:** `resources/views/public/skm.blade.php`

**Variabel dari Controller:**
```php
// SkmController.php
$skmData = DataSkm::orderBy('tahun')->get();
// Kolom: id, tahun, target, realisasi
```

**Digunakan di View:**
```blade
{{-- Stat cards --}}
@foreach($skmData as $skm)
  {{ $skm->tahun }}       {{-- baris ~26 --}}
  {{ $skm->realisasi }}   {{-- baris ~27 --}}
  {{ $skm->target }}      {{-- baris ~62, 63 --}}
@endforeach

{{-- Chart.js via @push('scripts') --}}
const labels    = @json($skmData->pluck('tahun'));     {{-- baris ~99 --}}
const targets   = @json($skmData->pluck('target'));    {{-- baris ~100 --}}
const realisasi = @json($skmData->pluck('realisasi')); {{-- baris ~101 --}}
```

**Library yang diload:** Chart.js 4.4.0 (CDN) — Bar chart

---

### 4. Data Ekspor (`/ekspor`)
**Controller:** `EksporController@index`
**View:** `resources/views/public/ekspor.blade.php`

**Variabel dari Controller:**
```php
// EksporController.php
$years      = DataEkspor::selectRaw('DISTINCT tahun')->orderBy('tahun')->pluck('tahun');
$eksporData = DataEkspor::orderBy('tahun')->orderBy('bulan')->get();
// Kolom: id, bulan (1-12), tahun, frekuensi, volume, nilai
```

**Digunakan di View:**
```blade
{{-- Year filter buttons --}}
@foreach($years as $y)
  <button onclick="setYear({{ $y }}, this)">{{ $y }}</button>
@endforeach

{{-- Chart.js via @push('scripts') --}}
const eksporAll = @json($eksporData);  {{-- semua data, filter di JS --}}
const years     = @json($years);       {{-- array tahun untuk inisialisasi --}}
```

**Cara kerja client-side filtering:**
```javascript
function initCharts(year) {
  // Filter dari semua data berdasarkan tahun yang dipilih
  const rows = eksporAll.filter(r => r.tahun == year);
  // Susun array 12 elemen (per bulan)
  const frek = Array(12).fill(0);
  rows.forEach(r => { frek[r.bulan - 1] = r.frekuensi; });
  // Render 3 chart: Frekuensi, Volume, Nilai
}
```

**Library yang diload:** Chart.js 4.4.0 (CDN) — 3 Line charts

---

### 5. Media (`/media`)
**Controller:** `MediaController@index`
**View:** `resources/views/public/media.blade.php`

Konten:
- Galeri foto kegiatan
- Berita/artikel terbaru
- Konten statis (tidak ada query database)

---

### 6. Aplikasi (`/aplikasi`)
**Controller:** `AplikasiController@index`
**View:** `resources/views/public/aplikasi.blade.php`

Konten:
- Daftar aplikasi digital yang digunakan/dikembangkan
- Link ke sistem/aplikasi terkait
- Konten statis

---

### 7. Regulasi (`/regulasi`)
**Controller:** `RegulasiController@index`
**View:** `resources/views/public/regulasi.blade.php`

Konten:
- Daftar peraturan dan regulasi terkait
- Unduh dokumen regulasi
- Konten statis

---

### 8. Tentang Kami (`/tentang-kami`)
**Controller:** `TentangKamiController@index`
**View:** `resources/views/public/tentang-kami.blade.php`

Konten:
- Profil instansi Balai PPMHKP Lampung
- Visi & Misi
- Struktur organisasi
- Lokasi & kontak
- Konten statis

---

## Komponen Bersama di Layout Publik

### Navbar Active State

Di setiap link navbar dalam `layouts/public.blade.php`, class `active` ditambahkan berdasarkan route saat ini:

```blade
{{-- layouts/public.blade.php baris ~119-128 --}}
<a href="{{ route('beranda') }}"
   class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}">
  Beranda
</a>
```

### Dark Mode Toggle

```javascript
// layouts/public.blade.php baris ~221-231
(function(){
  const t = localStorage.getItem('onetouchTheme') || 'light';
  if(t === 'dark') {
    document.body.classList.add('dark-mode');  // class pada <body>
    // update icon
  }
})();

function togglePublicTheme(){
  const isDark = document.body.classList.toggle('dark-mode');
  localStorage.setItem('onetouchTheme', isDark ? 'dark' : 'light');
}
```

CSS variables aktif saat `body.dark-mode`:
```css
/* layouts/public.blade.php baris ~22-28 */
body.dark-mode {
  --surface:    #1e293b;
  --surface-2:  #0f172a;
  --border:     #334155;
  --text:       #f1f5f9;
  --text-muted: #94a3b8;
}
```
