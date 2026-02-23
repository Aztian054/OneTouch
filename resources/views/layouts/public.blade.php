<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Portal') — ONE TOUCH Balai PPMHKP Lampung</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
  --navy:       #0f172a;
  --navy-800:   #1e293b;
  --gold:       #d4af37;
  --gold-dark:  #b8960a;
  --surface:    #ffffff;
  --surface-2:  #f8fafc;
  --border:     #e2e8f0;
  --text:       #1e293b;
  --text-muted: #64748b;
}
body.dark-mode {
  --surface:    #1e293b;
  --surface-2:  #0f172a;
  --border:     #334155;
  --text:       #f1f5f9;
  --text-muted: #94a3b8;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
  font-family: 'Inter', sans-serif;
  background: var(--surface-2);
  color: var(--text);
  font-size: 15px; line-height: 1.7;
  transition: background .3s, color .3s;
}

/* ── SITE HEADER ── */
.site-header {
  background: var(--navy);
  border-bottom: 3px solid var(--gold);
}
.header-top {
  display: flex; align-items: center;
  padding: 12px 40px; gap: 16px;
  border-bottom: 1px solid rgba(255,255,255,.06);
}
.header-logos { display: flex; align-items: center; gap: 14px; }
.header-logos img { height: 52px; width: auto; object-fit: contain; }
.header-divider {
  width: 1px; height: 40px; background: rgba(255,255,255,.2);
}
.header-title-block { flex: 1; }
.header-title-block .main-title {
  font-size: 13px; font-weight: 700; color: var(--gold);
  letter-spacing: .5px; text-transform: uppercase;
}
.header-title-block .sub-title {
  font-size: 11px; color: rgba(255,255,255,.5);
  margin-top: 1px;
}
.header-actions { display: flex; align-items: center; gap: 10px; }
.btn-login {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 8px 18px; border-radius: 8px;
  background: var(--gold); color: var(--navy);
  font-size: 13px; font-weight: 600; text-decoration: none;
  transition: background .18s;
}
.btn-login:hover { background: var(--gold-dark); }
.btn-theme-pub {
  width: 36px; height: 36px; border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.15);
  color: rgba(255,255,255,.7); cursor: pointer; font-size: 14px;
  transition: all .18s;
}
.btn-theme-pub:hover { background: rgba(255,255,255,.18); color: #fff; }

/* ── NAVBAR ── */
.site-nav {
  padding: 0 40px;
  display: flex; align-items: center; gap: 2px;
  overflow-x: auto;
}
.site-nav::-webkit-scrollbar { display: none; }
.nav-link {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 14px 16px;
  color: rgba(255,255,255,.6);
  text-decoration: none; font-size: 13.5px; font-weight: 500;
  border-bottom: 3px solid transparent;
  transition: all .18s; white-space: nowrap;
}
.nav-link:hover  { color: #fff; border-bottom-color: rgba(212,175,55,.4); }
.nav-link.active { color: var(--gold); border-bottom-color: var(--gold); }
.nav-link i { font-size: 13px; }

/* ── HERO ── */
.page-hero {
  background: linear-gradient(135deg, var(--navy) 0%, #1e3a5f 100%);
  padding: 56px 40px;
  text-align: center;
  position: relative; overflow: hidden;
}
.page-hero::before {
  content: '';
  position: absolute; inset: 0;
  background: url("{{ asset('assets/bg-dark.jpg') }}") center/cover;
  opacity: .07;
}
.page-hero .hero-badge {
  display: inline-flex; align-items: center; gap: 6px;
  background: rgba(212,175,55,.15); border: 1px solid rgba(212,175,55,.3);
  color: var(--gold); padding: 5px 14px; border-radius: 20px;
  font-size: 12px; font-weight: 600; letter-spacing: .5px;
  margin-bottom: 16px;
}
.page-hero h1 {
  font-size: clamp(24px, 4vw, 40px); font-weight: 800;
  color: #fff; line-height: 1.2; margin-bottom: 12px;
  position: relative;
}
.page-hero p {
  font-size: 16px; color: rgba(255,255,255,.65);
  max-width: 600px; margin: 0 auto;
  position: relative;
}

/* ── CONTAINER ── */
.container { max-width: 1200px; margin: 0 auto; padding: 0 40px; }

/* ── SECTION ── */
.section { padding: 56px 0; }
.section-title {
  font-size: 24px; font-weight: 700; color: var(--text);
  margin-bottom: 6px;
}
.section-subtitle { font-size: 14px; color: var(--text-muted); margin-bottom: 32px; }

/* ── CARD ── */
.pub-card {
  background: var(--surface); border-radius: 12px;
  border: 1px solid var(--border); padding: 24px;
  transition: box-shadow .2s, transform .2s;
}
.pub-card:hover {
  box-shadow: 0 8px 24px rgba(0,0,0,.08);
  transform: translateY(-2px);
}

/* ── FOOTER ── */
.site-footer {
  background: var(--navy); color: rgba(255,255,255,.6);
  padding: 40px 0 20px;
}
.footer-grid {
  display: grid; grid-template-columns: 2fr 1fr 1fr;
  gap: 32px; padding-bottom: 32px;
  border-bottom: 1px solid rgba(255,255,255,.08);
}
.footer-brand img { height: 50px; margin-bottom: 12px; }
.footer-brand p { font-size: 13px; line-height: 1.7; }
.footer-title {
  font-size: 12px; font-weight: 700; color: var(--gold);
  letter-spacing: 1px; text-transform: uppercase; margin-bottom: 14px;
}
.footer-links { list-style: none; }
.footer-links li { margin-bottom: 8px; }
.footer-links a {
  color: rgba(255,255,255,.55); text-decoration: none;
  font-size: 13px; transition: color .15s;
}
.footer-links a:hover { color: var(--gold); }
.footer-bottom {
  padding-top: 20px;
  display: flex; align-items: center; justify-content: space-between;
  flex-wrap: wrap; gap: 8px;
}
.footer-bottom p { font-size: 12px; }
.footer-bottom a { color: var(--gold); text-decoration: none; }

/* ── UTILS ── */
.text-gold { color: var(--gold); }
.text-navy { color: var(--navy); }
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
.grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; }
.grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; }

/* ── MOBILE NAV ── */
.mobile-nav-toggle {
  display: none; background: none; border: none; cursor: pointer;
  color: rgba(255,255,255,.7); font-size: 20px; padding: 4px;
}

@media(max-width:900px){
  .header-top { padding: 12px 20px; }
  .site-nav { padding: 0 20px; }
  .container { padding: 0 20px; }
  .page-hero { padding: 36px 20px; }
  .footer-grid { grid-template-columns: 1fr; gap: 24px; }
  .grid-2,.grid-3,.grid-4 { grid-template-columns: 1fr; }
  .header-title-block .sub-title { display: none; }
}
</style>
@stack('styles')
</head>
<body id="pub-body">

<header class="site-header">
  <div class="header-top">
    <div class="header-logos">
      <img src="{{ asset('assets/header-logo1-kkp.png') }}" alt="KKP">
      <div class="header-divider"></div>
      <img src="{{ asset('assets/header-logo2-bppmhkp.png') }}" alt="BPPMHKP">
    </div>
    <div class="header-title-block">
      <div class="main-title">Balai PPMHKP Lampung</div>
      <div class="sub-title">Kementerian Kelautan dan Perikanan — Sistem Layanan ONE TOUCH</div>
    </div>
    <div class="header-actions">
      <button class="btn-theme-pub" onclick="togglePublicTheme()" id="pubThemeBtn" title="Ganti tema">
        <i class="fas fa-moon" id="pubThemeIcon"></i>
      </button>
      <a href="{{ route('login') }}" class="btn-login">
        <i class="fas fa-right-to-bracket"></i>
        Masuk Sistem
      </a>
    </div>
  </div>
  <nav class="site-nav">
    <a href="{{ route('beranda') }}"     class="nav-link {{ request()->routeIs('beranda')      ? 'active' : '' }}"><i class="fas fa-house"></i> Beranda</a>
    <a href="{{ route('layanan') }}"     class="nav-link {{ request()->routeIs('layanan')      ? 'active' : '' }}"><i class="fas fa-list-check"></i> Layanan</a>
    <a href="{{ route('skm') }}"         class="nav-link {{ request()->routeIs('skm')          ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> SKM</a>
    <a href="{{ route('ekspor') }}"      class="nav-link {{ request()->routeIs('ekspor')       ? 'active' : '' }}"><i class="fas fa-ship"></i> Ekspor</a>
    <a href="{{ route('media') }}"       class="nav-link {{ request()->routeIs('media')        ? 'active' : '' }}"><i class="fas fa-photo-film"></i> Media</a>
    <a href="{{ route('aplikasi') }}"    class="nav-link {{ request()->routeIs('aplikasi')     ? 'active' : '' }}"><i class="fas fa-grid-2"></i> Aplikasi</a>
    <a href="{{ route('regulasi') }}"    class="nav-link {{ request()->routeIs('regulasi')     ? 'active' : '' }}"><i class="fas fa-scale-balanced"></i> Regulasi</a>
    <a href="{{ route('tentang-kami') }}" class="nav-link {{ request()->routeIs('tentang-kami') ? 'active' : '' }}"><i class="fas fa-building"></i> Tentang Kami</a>
  </nav>
</header>

@yield('content')

<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <img src="{{ asset('assets/Portal-LogoKKP-TeksPutih.png') }}" alt="KKP">
        <p>Balai Pengujian, Penerapan Mutu dan Hasil Kelautan dan Perikanan (PPMHKP) Lampung memberikan layanan sertifikasi mutu hasil perikanan.</p>
      </div>
      <div>
        <div class="footer-title">Menu Utama</div>
        <ul class="footer-links">
          <li><a href="{{ route('beranda') }}">Beranda</a></li>
          <li><a href="{{ route('layanan') }}">Layanan</a></li>
          <li><a href="{{ route('skm') }}">SKM</a></li>
          <li><a href="{{ route('ekspor') }}">Data Ekspor</a></li>
          <li><a href="{{ route('media') }}">Media</a></li>
          <li><a href="{{ route('aplikasi') }}">Aplikasi</a></li>
          <li><a href="{{ route('regulasi') }}">Regulasi</a></li>
          <li><a href="{{ route('tentang-kami') }}">Tentang Kami</a></li>
        </ul>
      </div>
      <div>
        <div class="footer-title">Kontak</div>
        <ul class="footer-links">
          <li><a href="#"><i class="fas fa-map-marker-alt" style="width:16px"></i> Bandar Lampung</a></li>
          <li><a href="#"><i class="fas fa-phone" style="width:16px"></i> (0721) 000-0000</a></li>
          <li><a href="#"><i class="fas fa-envelope" style="width:16px"></i> info@ppmhkp-lampung.kkp.go.id</a></li>
          <li style="margin-top:12px"><a href="{{ route('login') }}" style="color:var(--gold)"><i class="fas fa-lock" style="width:16px"></i>OneTouch🔑</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; {{ date('Y') }} Balai PPMHKP Lampung — Kementerian Kelautan dan Perikanan</p>
      <p>Sistem <a href="#">ONE TOUCH</a></p>
    </div>
  </div>
</footer>

<script>
(function(){
  const t = localStorage.getItem('onetouchTheme') || 'light';
  if(t === 'dark') {
    document.body.classList.add('dark-mode');
    const icon = document.getElementById('pubThemeIcon');
    if(icon) icon.className = 'fas fa-sun';
  }
})();

function togglePublicTheme(){
  const isDark = document.body.classList.toggle('dark-mode');
  localStorage.setItem('onetouchTheme', isDark ? 'dark' : 'light');
  const icon = document.getElementById('pubThemeIcon');
  icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
}
</script>
@stack('scripts')
</body>
</html>
