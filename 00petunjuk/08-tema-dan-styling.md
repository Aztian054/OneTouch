# 08 — Tema & Styling (Dark/Light Mode)

## Arsitektur Styling

ONE TOUCH **tidak menggunakan framework CSS** (tidak ada Bootstrap/Tailwind). Semua styling ditulis langsung di dalam file Blade layout menggunakan tag `<style>`.

### Filosofi:
- CSS Custom Properties (variables) untuk theming
- 2 layout terpisah dengan sistem dark mode berbeda
- Per-page styles via `@push('styles')`

---

## Dua Sistem Dark Mode

| Aspek                | Portal Publik                    | Sistem Internal                  |
|----------------------|----------------------------------|----------------------------------|
| **File layout**      | `layouts/public.blade.php`       | `layouts/internal.blade.php`     |
| **localStorage key** | `onetouchTheme`                  | `theme`                          |
| **CSS selector**     | `body.dark-mode { ... }`         | `html.dark { ... }`              |
| **Class target**     | `document.body`                  | `document.documentElement`       |
| **Nilai dark**       | `'dark'`                         | `'dark'`                         |
| **Nilai light**      | `'light'`                        | `'light'`                        |

> ⚠️ **PENTING:** Kedua sistem ini **terpisah** dan tidak saling mempengaruhi.
> localStorage key yang berbeda (`onetouchTheme` vs `theme`) berarti preferensi tema di portal publik tidak otomatis diterapkan di sistem internal.

---

## Portal Publik — `layouts/public.blade.php`

### CSS Variables

```css
/* Baris ~14-20: Light mode (default) */
:root {
  --navy:       #0f172a;
  --navy-800:   #1e293b;
  --gold:       #d4af37;
  --gold-dark:  #b8960a;
  --surface:    #ffffff;     /* background card */
  --surface-2:  #f8fafc;     /* background halaman */
  --border:     #e2e8f0;     /* warna border */
  --text:       #1e293b;     /* warna teks utama */
  --text-muted: #64748b;     /* warna teks sekunder */
}

/* Baris ~22-28: Dark mode override */
body.dark-mode {
  --surface:    #1e293b;
  --surface-2:  #0f172a;
  --border:     #334155;
  --text:       #f1f5f9;
  --text-muted: #94a3b8;
}
```

**Variable yang TIDAK berubah saat dark mode** (tetap sama):
- `--navy`, `--navy-800` — navbar & footer selalu dark
- `--gold`, `--gold-dark` — aksen emas selalu sama

### JavaScript Dark Mode (baris ~221-234)

```javascript
/* IIFE — dijalankan saat halaman dimuat, sebelum render */
(function(){
  const t = localStorage.getItem('onetouchTheme') || 'light';
  if(t === 'dark') {
    document.body.classList.add('dark-mode');
    const icon = document.getElementById('pubThemeIcon');
    if(icon) icon.className = 'fas fa-sun';   // icon matahari = mode gelap aktif
  }
})();

/* Toggle function — dipanggil tombol di navbar */
function togglePublicTheme(){
  const isDark = document.body.classList.toggle('dark-mode');
  localStorage.setItem('onetouchTheme', isDark ? 'dark' : 'light');
  const icon = document.getElementById('pubThemeIcon');
  icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
}
```

### Tombol Toggle (HTML, baris ~113-115)

```html
<button class="btn-theme-pub" onclick="togglePublicTheme()" id="pubThemeBtn">
  <i class="fas fa-moon" id="pubThemeIcon"></i>
</button>
```

---

## Sistem Internal — `layouts/internal.blade.php`

### CSS Variables

```css
/* :root — Light mode */
:root {
  --sidebar-width: 240px;
  --navy:    #0f172a;
  --gold:    #d4af37;
  --surface:   #ffffff;
  --surface-2: #f8fafc;
  --border:    #e2e8f0;
  --text:      #1e293b;
  --text-muted: #64748b;
  --sidebar-bg: #0f172a;
  --topbar-bg:  #ffffff;
}

/* html.dark — Dark mode */
html.dark {
  --surface:    #1e293b;
  --surface-2:  #0f172a;
  --border:     #334155;
  --text:       #f1f5f9;
  --text-muted: #94a3b8;
  --topbar-bg:  #1e293b;
}
```

### JavaScript Dark Mode

```javascript
/* Dijalankan awal halaman load */
const saved = localStorage.getItem('theme') || 'light';
document.documentElement.className = saved;  // Set class pada <html>

function toggleTheme() {
  const next = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
  document.documentElement.className = next;
  localStorage.setItem('theme', next);
  // Update icon
  document.getElementById('themeIcon').className =
    next === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
}
```

---

## Cara Komponen Merespons Dark Mode

### Contoh: Card

```css
/* Card selalu menggunakan CSS variable */
.card {
  background: var(--surface);   /* putih di light, #1e293b di dark */
  border: 1px solid var(--border);
}
```

Tidak perlu menulis ulang style untuk dark mode — cukup definisikan variable di `body.dark-mode` atau `html.dark`, semua komponen otomatis berubah.

---

## Responsive Design

Layout menggunakan breakpoint `900px`:

```css
@media(max-width: 900px) {
  /* Public */
  .header-top { padding: 12px 20px; }
  .footer-grid { grid-template-columns: 1fr; }
  .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }

  /* Internal */
  .sidebar { transform: translateX(-100%); }  /* sidebar collapse */
  .main-content { margin-left: 0; }
}
```

---

## Warna Utama

| Variable      | Light Mode  | Dark Mode   | Keterangan         |
|---------------|-------------|-------------|--------------------|
| `--navy`      | `#0f172a`   | `#0f172a`   | Biru tua (navbar)  |
| `--gold`      | `#d4af37`   | `#d4af37`   | Emas (aksen)       |
| `--surface`   | `#ffffff`   | `#1e293b`   | Background card    |
| `--surface-2` | `#f8fafc`   | `#0f172a`   | Background halaman |
| `--border`    | `#e2e8f0`   | `#334155`   | Warna border       |
| `--text`      | `#1e293b`   | `#f1f5f9`   | Teks utama         |
| `--text-muted`| `#64748b`   | `#94a3b8`   | Teks sekunder      |

---

## Per-Page Styles

Setiap halaman bisa menambahkan CSS tambahan melalui `@push('styles')`:

```blade
{{-- resources/views/public/skm.blade.php --}}
@push('styles')
<style>
  .skm-stat { ... }
  .skm-stat-value { font-size: 28px; font-weight: 800; color: var(--navy); }
</style>
@endpush
```

CSS ini di-inject ke `@stack('styles')` di dalam `<head>` layout, setelah CSS global.

---

## Chart.js & Dark Mode

Halaman SKM dan Ekspor menggunakan Chart.js. Warna chart disesuaikan dengan mode saat ini:

```javascript
// Cek mode saat ini
const isDark = document.documentElement.classList.contains('dark')  // internal
            || document.body.classList.contains('dark-mode');        // public

const gridColor = isDark ? 'rgba(255,255,255,.08)' : 'rgba(0,0,0,.06)';
const textColor = isDark ? 'rgba(255,255,255,.6)'  : 'rgba(15,23,42,.6)';

// Digunakan di scales.x.ticks.color, scales.y.grid.color, dll
```

> ⚠️ **Catatan:** Chart.js tidak otomatis update saat toggle dark mode. Chart dirender sekali saat halaman load. Untuk mendukung live toggle, perlu destroy & rebuild chart saat tema berubah.
