<!DOCTYPE html>
<html lang="id" class="{{ session('theme', 'light') }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') — ONE TOUCH</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* ── TOKENS ── */
:root {
  --navy:        #0f172a;
  --navy-800:    #1e293b;
  --navy-700:    #334155;
  --gold:        #d4af37;
  --gold-light:  #f5e596;
  --surface:     #ffffff;
  --surface-2:   #f8fafc;
  --border:      #e2e8f0;
  --text:        #1e293b;
  --text-muted:  #64748b;
  --success:     #22c55e;
  --warning:     #f59e0b;
  --danger:      #ef4444;
  --info:        #3b82f6;
  --sidebar-w:   260px;
  --topbar-h:    60px;
  --radius:      10px;
  --shadow:      0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.06);
  --shadow-md:   0 4px 6px -1px rgba(0,0,0,.1), 0 2px 4px -1px rgba(0,0,0,.06);
}
html.dark {
  --surface:    #1e293b;
  --surface-2:  #0f172a;
  --border:     #334155;
  --text:       #f1f5f9;
  --text-muted: #94a3b8;
}

/* ── RESET ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
  font-family: 'Inter', sans-serif;
  background: var(--surface-2);
  color: var(--text);
  font-size: 14px;
  line-height: 1.6;
  min-height: 100vh;
  display: flex;
}

/* ── SIDEBAR ── */
.sidebar {
  width: var(--sidebar-w);
  min-height: 100vh;
  background: var(--navy);
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0; left: 0;
  z-index: 100;
  transition: transform .3s ease;
}
.sidebar-logo {
  padding: 20px 20px 16px;
  border-bottom: 1px solid rgba(255,255,255,.08);
  display: flex; align-items: center; gap: 10px;
}
.sidebar-logo img { width: 38px; height: 38px; object-fit: contain; }
.sidebar-logo-text .app-name {
  font-size: 15px; font-weight: 700; color: #fff; letter-spacing: .5px;
}
.sidebar-logo-text .app-sub {
  font-size: 10px; color: rgba(255,255,255,.45); line-height: 1.3;
}
.sidebar-nav { flex: 1; padding: 12px 0; overflow-y: auto; }
.nav-section-label {
  font-size: 10px; font-weight: 600; color: rgba(255,255,255,.35);
  letter-spacing: 1px; text-transform: uppercase;
  padding: 14px 20px 6px;
}
.nav-item {
  display: flex; align-items: center; gap: 12px;
  padding: 10px 20px;
  color: rgba(255,255,255,.65);
  text-decoration: none;
  font-size: 13.5px; font-weight: 500;
  border-left: 3px solid transparent;
  transition: all .18s ease;
  cursor: pointer;
}
.nav-item:hover {
  background: rgba(255,255,255,.06);
  color: #fff;
  border-left-color: rgba(255,255,255,.2);
}
.nav-item.active {
  background: rgba(212,175,55,.12);
  color: var(--gold);
  border-left-color: var(--gold);
}
.nav-item i { width: 18px; text-align: center; font-size: 14px; flex-shrink: 0; }
.sidebar-footer {
  padding: 16px 20px;
  border-top: 1px solid rgba(255,255,255,.08);
}
.sidebar-user {
  display: flex; align-items: center; gap: 10px;
  padding: 8px 10px; border-radius: 8px;
  background: rgba(255,255,255,.05);
}
.sidebar-user-avatar {
  width: 32px; height: 32px; border-radius: 50%;
  background: var(--gold); color: var(--navy);
  display: flex; align-items: center; justify-content: center;
  font-size: 13px; font-weight: 700; flex-shrink: 0;
}
.sidebar-user-info .name { font-size: 12.5px; font-weight: 600; color: #fff; }
.sidebar-user-info .role {
  font-size: 10px; color: rgba(255,255,255,.4);
  text-transform: capitalize;
}

/* ── MAIN ── */
.main-wrap {
  flex: 1;
  margin-left: var(--sidebar-w);
  display: flex; flex-direction: column;
  min-height: 100vh;
}

/* ── TOPBAR ── */
.topbar {
  height: var(--topbar-h);
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center;
  padding: 0 24px;
  gap: 16px;
  position: sticky; top: 0; z-index: 50;
  box-shadow: var(--shadow);
}
.topbar-breadcrumb {
  flex: 1;
  font-size: 13px; color: var(--text-muted);
  display: flex; align-items: center; gap: 6px;
}
.topbar-breadcrumb .current { color: var(--text); font-weight: 600; }
.topbar-actions { display: flex; align-items: center; gap: 10px; }
.btn-icon {
  width: 36px; height: 36px; border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  background: var(--surface-2); border: 1px solid var(--border);
  color: var(--text-muted); cursor: pointer;
  transition: all .18s ease; font-size: 14px;
}
.btn-icon:hover { background: var(--border); color: var(--text); }
.topbar-user {
  display: flex; align-items: center; gap: 8px;
  padding: 6px 12px; border-radius: 8px;
  background: var(--surface-2); border: 1px solid var(--border);
  cursor: pointer; font-size: 13px; color: var(--text);
  font-weight: 500; text-decoration: none;
  transition: background .18s;
}
.topbar-user:hover { background: var(--border); }
.topbar-user-avatar {
  width: 26px; height: 26px; border-radius: 50%;
  background: var(--gold); color: var(--navy);
  display: flex; align-items: center; justify-content: center;
  font-size: 11px; font-weight: 700;
}

/* ── PAGE CONTENT ── */
.page-content { flex: 1; padding: 28px 28px 40px; }
.page-header {
  display: flex; align-items: flex-start; justify-content: space-between;
  margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
}
.page-title { font-size: 20px; font-weight: 700; color: var(--text); }
.page-subtitle { font-size: 13px; color: var(--text-muted); margin-top: 2px; }

/* ── CARDS ── */
.card {
  background: var(--surface); border-radius: var(--radius);
  border: 1px solid var(--border); box-shadow: var(--shadow);
  overflow: hidden;
}
.card-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
}
.card-title { font-size: 15px; font-weight: 600; color: var(--text); }
.card-body { padding: 20px; }

/* ── STAT CARDS ── */
.stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
.stat-card {
  background: var(--surface); border-radius: var(--radius);
  border: 1px solid var(--border); padding: 20px;
  display: flex; align-items: center; gap: 14px;
  box-shadow: var(--shadow); transition: box-shadow .2s;
}
.stat-card:hover { box-shadow: var(--shadow-md); }
.stat-icon {
  width: 46px; height: 46px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px; flex-shrink: 0;
}
.stat-icon.navy    { background: rgba(15,23,42,.08); color: var(--navy); }
.stat-icon.gold    { background: rgba(212,175,55,.12); color: #b8960a; }
.stat-icon.success { background: rgba(34,197,94,.1); color: #16a34a; }
.stat-icon.warning { background: rgba(245,158,11,.1); color: #d97706; }
.stat-icon.danger  { background: rgba(239,68,68,.1); color: #dc2626; }
.stat-icon.info    { background: rgba(59,130,246,.1); color: #2563eb; }
html.dark .stat-icon.navy { background: rgba(255,255,255,.08); color: #e2e8f0; }
.stat-value { font-size: 24px; font-weight: 700; color: var(--text); line-height: 1; }
.stat-label { font-size: 12px; color: var(--text-muted); margin-top: 3px; }

/* ── TABLES ── */
.table-wrap { overflow-x: auto; }
table.data-table { width: 100%; border-collapse: collapse; }
table.data-table th {
  background: var(--surface-2); font-size: 11.5px; font-weight: 600;
  color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px;
  padding: 10px 14px; border-bottom: 1px solid var(--border);
  white-space: nowrap;
}
table.data-table td {
  padding: 12px 14px; border-bottom: 1px solid var(--border);
  font-size: 13.5px; color: var(--text); vertical-align: middle;
}
table.data-table tr:last-child td { border-bottom: none; }
table.data-table tbody tr:hover td { background: var(--surface-2); }

/* ── BADGES ── */
.badge {
  display: inline-flex; align-items: center;
  padding: 3px 9px; border-radius: 20px;
  font-size: 11px; font-weight: 600; white-space: nowrap;
}
.badge-aktif    { background: #dcfce7; color: #15803d; }
.badge-warning  { background: #fef9c3; color: #a16207; }
.badge-expired  { background: #fee2e2; color: #b91c1c; }
.badge-admin    { background: rgba(212,175,55,.15); color: #92660c; }
.badge-officer  { background: rgba(59,130,246,.12); color: #1d4ed8; }
.badge-user     { background: rgba(34,197,94,.12); color: #166534; }
.badge-pending  { background: #f1f5f9; color: #475569; }
.badge-process  { background: rgba(245,158,11,.12); color: #b45309; }
.badge-completed { background: #dcfce7; color: #15803d; }
.badge-terkirim  { background: #dcfce7; color: #15803d; }
.badge-tidak-ada { background: #fee2e2; color: #b91c1c; }
html.dark .badge-aktif { background: rgba(34,197,94,.18); }
html.dark .badge-warning { background: rgba(245,158,11,.18); }
html.dark .badge-expired { background: rgba(239,68,68,.18); }

/* ── BUTTONS ── */
.btn {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 8px 16px; border-radius: 8px; border: none;
  font-family: inherit; font-size: 13.5px; font-weight: 500;
  cursor: pointer; text-decoration: none;
  transition: all .18s ease; white-space: nowrap;
}
.btn-primary   { background: var(--navy); color: #fff; }
.btn-primary:hover { background: var(--navy-800); }
.btn-gold      { background: var(--gold); color: var(--navy); font-weight: 600; }
.btn-gold:hover { background: #c09b28; }
.btn-outline   { background: transparent; border: 1.5px solid var(--border); color: var(--text); }
.btn-outline:hover { background: var(--surface-2); }
.btn-danger    { background: var(--danger); color: #fff; }
.btn-danger:hover { background: #dc2626; }
.btn-sm { padding: 5px 10px; font-size: 12px; border-radius: 6px; }
.btn-xs { padding: 3px 8px; font-size: 11px; border-radius: 5px; gap: 4px; }

/* ── FORMS ── */
.form-group { margin-bottom: 18px; }
.form-label {
  display: block; font-size: 13px; font-weight: 500;
  color: var(--text); margin-bottom: 6px;
}
.form-label .req { color: var(--danger); margin-left: 2px; }
.form-control, .form-select {
  width: 100%; padding: 9px 12px; border-radius: 8px;
  border: 1.5px solid var(--border); background: var(--surface);
  color: var(--text); font-family: inherit; font-size: 13.5px;
  transition: border-color .18s;
  appearance: none;
}
.form-control:focus, .form-select:focus {
  outline: none; border-color: var(--gold); box-shadow: 0 0 0 3px rgba(212,175,55,.15);
}
.form-control::placeholder { color: var(--text-muted); }
textarea.form-control { resize: vertical; min-height: 90px; }
.form-hint { font-size: 11.5px; color: var(--text-muted); margin-top: 4px; }
.form-error { font-size: 11.5px; color: var(--danger); margin-top: 4px; }
.form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }

/* ── ALERTS ── */
.alert {
  padding: 12px 16px; border-radius: 8px;
  font-size: 13.5px; margin-bottom: 20px;
  display: flex; align-items: flex-start; gap: 10px;
}
.alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
.alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
.alert-warning { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
html.dark .alert-success { background: rgba(34,197,94,.1); border-color: rgba(34,197,94,.25); color: #86efac; }
html.dark .alert-error   { background: rgba(239,68,68,.1);  border-color: rgba(239,68,68,.25);  color: #fca5a5; }

/* ── PAGINATION ── */
.pagination { display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }
.pagination .page-link {
  min-width: 34px; height: 34px; padding: 0 10px;
  display: flex; align-items: center; justify-content: center;
  border-radius: 7px; border: 1px solid var(--border);
  background: var(--surface); color: var(--text);
  font-size: 13px; text-decoration: none; transition: all .15s;
}
.pagination .page-link:hover { background: var(--border); }
.pagination .page-link.active { background: var(--navy); border-color: var(--navy); color: #fff; }

/* ── FILTER BAR ── */
.filter-bar {
  display: flex; align-items: center; gap: 10px;
  flex-wrap: wrap; margin-bottom: 20px;
}
.filter-bar .form-control, .filter-bar .form-select {
  width: auto; min-width: 150px;
}
.search-wrap { position: relative; }
.search-wrap .form-control { padding-left: 34px; }
.search-wrap i {
  position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
  color: var(--text-muted); font-size: 13px; pointer-events: none;
}

/* ── MOBILE MENU TOGGLE ── */
.menu-toggle { display: none; }

/* ── LOGOUT FORM ── */
.logout-link { background: none; border: none; color: inherit; cursor: pointer;
  font-family: inherit; font-size: inherit; padding: 0; }

/* ── DETAIL DL ── */
.detail-grid { display: grid; grid-template-columns: 180px 1fr; gap: 10px 16px; }
.detail-label { font-size: 12.5px; font-weight: 600; color: var(--text-muted); }
.detail-value { font-size: 13.5px; color: var(--text); }

/* ── EMPTY STATE ── */
.empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
.empty-state i { font-size: 40px; margin-bottom: 12px; opacity: .4; }
.empty-state p { font-size: 14px; }

@media (max-width: 900px) {
  .sidebar { transform: translateX(-100%); }
  .sidebar.open { transform: translateX(0); }
  .main-wrap { margin-left: 0; }
  .menu-toggle { display: flex; }
  .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; }
  .stats-grid { grid-template-columns: 1fr 1fr; }
}
</style>
@stack('styles')
</head>
<body id="app-body">

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    <img src="{{ asset('assets/Portal-LogoKKPRound-Warna.png') }}" alt="KKP">
    <div class="sidebar-logo-text">
      <div class="app-name">ONE TOUCH</div>
      <div class="app-sub">Balai PPMHKP Lampung</div>
    </div>
  </div>

  <nav class="sidebar-nav">
    @php $role = auth()->user()->role; @endphp

    {{-- ADMIN --}}
    @if($role === 'admin')
    <div class="nav-section-label">Dashboard</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="fas fa-gauge-high"></i> Dashboard
    </a>
    <div class="nav-section-label">Manajemen Data</div>
    <a href="{{ route('admin.sertifikat.index') }}" class="nav-item {{ request()->routeIs('admin.sertifikat*') ? 'active' : '' }}">
      <i class="fas fa-certificate"></i> Sertifikat
    </a>
    <a href="{{ route('admin.inspeksi.index') }}" class="nav-item {{ request()->routeIs('admin.inspeksi*') ? 'active' : '' }}">
      <i class="fas fa-clipboard-check"></i> Inspeksi
    </a>
    <div class="nav-section-label">Administrasi</div>
    <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
      <i class="fas fa-users"></i> Manajemen User
    </a>
    <a href="{{ route('admin.laporan.index') }}" class="nav-item {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
      <i class="fas fa-file-chart-column"></i> Laporan
    </a>

    {{-- OFFICER --}}
    @elseif($role === 'officer')
    <div class="nav-section-label">Dashboard</div>
    <a href="{{ route('officer.dashboard') }}" class="nav-item {{ request()->routeIs('officer.dashboard') ? 'active' : '' }}">
      <i class="fas fa-gauge-high"></i> Dashboard
    </a>
    <div class="nav-section-label">Manajemen Data</div>
    <a href="{{ route('officer.sertifikat.index') }}" class="nav-item {{ request()->routeIs('officer.sertifikat*') ? 'active' : '' }}">
      <i class="fas fa-certificate"></i> Sertifikat
    </a>
    <a href="{{ route('officer.inspeksi.index') }}" class="nav-item {{ request()->routeIs('officer.inspeksi*') ? 'active' : '' }}">
      <i class="fas fa-clipboard-check"></i> Inspeksi
    </a>
    <div class="nav-section-label">Laporan</div>
    <a href="{{ route('officer.laporan.index') }}" class="nav-item {{ request()->routeIs('officer.laporan*') ? 'active' : '' }}">
      <i class="fas fa-file-chart-column"></i> Laporan
    </a>

    {{-- USER --}}
    @elseif($role === 'user')
    <div class="nav-section-label">Dashboard</div>
    <a href="{{ route('user.dashboard') }}" class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
      <i class="fas fa-gauge-high"></i> Dashboard
    </a>
    <div class="nav-section-label">Data Saya</div>
    <a href="{{ route('user.sertifikat.index') }}" class="nav-item {{ request()->routeIs('user.sertifikat*') ? 'active' : '' }}">
      <i class="fas fa-certificate"></i> Sertifikat Saya
    </a>
    <a href="{{ route('user.inspeksi.index') }}" class="nav-item {{ request()->routeIs('user.inspeksi*') ? 'active' : '' }}">
      <i class="fas fa-clipboard-check"></i> Inspeksi Saya
    </a>
    <a href="{{ route('user.laporan.index') }}" class="nav-item {{ request()->routeIs('user.laporan*') ? 'active' : '' }}">
      <i class="fas fa-file-chart-column"></i> Laporan
    </a>
    @endif

    <div class="nav-section-label">Lainnya</div>
    <a href="{{ route('beranda') }}" class="nav-item" target="_blank">
      <i class="fas fa-globe"></i> Portal Publik
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
      <div class="sidebar-user-info">
        <div class="name">{{ auth()->user()->name }}</div>
        <div class="role">{{ ucfirst(auth()->user()->role) }}</div>
      </div>
    </div>
  </div>
</aside>

{{-- Main --}}
<div class="main-wrap">
  {{-- Topbar --}}
  <header class="topbar">
    <button class="btn-icon menu-toggle" id="menuToggle" onclick="toggleSidebar()">
      <i class="fas fa-bars"></i>
    </button>
    <div class="topbar-breadcrumb">
      <span>ONE TOUCH</span>
      <i class="fas fa-chevron-right" style="font-size:10px"></i>
      <span class="current">@yield('breadcrumb', 'Dashboard')</span>
    </div>
    <div class="topbar-actions">
      <button class="btn-icon" onclick="toggleTheme()" title="Ganti tema" id="themeBtn">
        <i class="fas fa-moon" id="themeIcon"></i>
      </button>
      <form action="{{ route('logout') }}" method="POST" style="margin:0">
        @csrf
        <button type="submit" class="topbar-user">
          <div class="topbar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
          <span>{{ auth()->user()->name }}</span>
          <i class="fas fa-right-from-bracket" style="font-size:12px;color:var(--text-muted)"></i>
        </button>
      </form>
    </div>
  </header>

  {{-- Content --}}
  <main class="page-content">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert alert-success">
      <i class="fas fa-circle-check"></i>
      <span>{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
      <i class="fas fa-circle-xmark"></i>
      <span>{{ session('error') }}</span>
    </div>
    @endif

    @yield('content')
  </main>
</div>

{{-- Overlay for mobile --}}
<div id="sidebarOverlay" onclick="toggleSidebar()"
  style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:99"></div>

<script>
// ── Theme ──
(function() {
  const saved = localStorage.getItem('onetouchTheme') || 'light';
  document.documentElement.className = saved;
  updateThemeIcon(saved);
})();

function updateThemeIcon(theme) {
  const icon = document.getElementById('themeIcon');
  if (!icon) return;
  icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
}

function toggleTheme() {
  const html = document.documentElement;
  const isDark = html.classList.contains('dark');
  const next = isDark ? 'light' : 'dark';
  html.className = next;
  localStorage.setItem('onetouchTheme', next);
  updateThemeIcon(next);
}

// ── Sidebar toggle (mobile) ──
function toggleSidebar() {
  const sb = document.getElementById('sidebar');
  const ov = document.getElementById('sidebarOverlay');
  const open = sb.classList.toggle('open');
  ov.style.display = open ? 'block' : 'none';
}

// ── Auto-dismiss alerts ──
setTimeout(() => {
  document.querySelectorAll('.alert').forEach(el => {
    el.style.transition = 'opacity .4s';
    el.style.opacity = '0';
    setTimeout(() => el.remove(), 400);
  });
}, 4000);
</script>
@stack('scripts')
</body>
</html>
