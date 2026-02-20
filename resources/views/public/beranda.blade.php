@extends('layouts.public')
@section('title', 'Beranda')
@push('styles')
<style>
/* ── HERO ── */
.hero-main {
  background: var(--navy); min-height: 520px;
  display: flex; align-items: center; justify-content: center;
  position: relative; overflow: hidden; padding: 80px 40px;
}
.hero-main::before {
  content:''; position:absolute; inset:0;
  background:url("{{ asset('assets/bg-dark.jpg') }}") center/cover; opacity:.08;
}
.hero-main::after {
  content:''; position:absolute; inset:0;
  background:linear-gradient(135deg,rgba(15,23,42,.95) 0%,rgba(30,58,95,.7) 100%);
}
.hero-content { position:relative; z-index:1; text-align:center; max-width:700px; margin:0 auto; }
.hero-badge {
  display:inline-flex; align-items:center; gap:6px;
  background:rgba(212,175,55,.15); border:1px solid rgba(212,175,55,.3);
  color:var(--gold); padding:6px 16px; border-radius:20px;
  font-size:12px; font-weight:600; letter-spacing:.5px; margin-bottom:20px;
}
.hero-title { font-size:clamp(28px,5vw,52px); font-weight:800; color:#fff; line-height:1.15; margin-bottom:16px; }
.hero-title .accent { color:var(--gold); }
.hero-desc { font-size:16px; color:rgba(255,255,255,.65); max-width:560px; margin:0 auto 32px; line-height:1.8; }
.hero-cta { display:flex; align-items:center; justify-content:center; gap:12px; flex-wrap:wrap; }
.hero-btn {
  display:inline-flex; align-items:center; gap:8px;
  padding:13px 28px; border-radius:10px; font-size:14px; font-weight:600;
  text-decoration:none; transition:all .2s;
}
.hero-btn-primary { background:var(--gold); color:var(--navy); }
.hero-btn-primary:hover { background:#c09b28; transform:translateY(-1px); }
.hero-btn-outline { background:transparent; border:1.5px solid rgba(255,255,255,.3); color:#fff; }
.hero-btn-outline:hover { border-color:var(--gold); color:var(--gold); }

/* ── PHOTO CAROUSEL ── */
.carousel-wrap { position:relative; overflow:hidden; height:260px; background:var(--navy); }
.carousel-track { display:flex; height:100%; transition:transform .6s ease; }
.carousel-slide {
  min-width:100%; height:100%; background:center/cover no-repeat;
  display:flex; align-items:flex-end;
  position:relative;
}
.carousel-slide::after {
  content:''; position:absolute; inset:0;
  background:linear-gradient(to top,rgba(15,23,42,.8) 0%,transparent 60%);
}
.slide-caption {
  position:relative; z-index:1; padding:20px 32px;
  color:#fff; font-size:14px; font-weight:600;
}
.carousel-dots { position:absolute; bottom:12px; left:50%; transform:translateX(-50%); display:flex; gap:6px; z-index:10; }
.carousel-dot {
  width:8px; height:8px; border-radius:50%;
  background:rgba(255,255,255,.4); cursor:pointer; border:none; transition:.2s;
}
.carousel-dot.active { background:var(--gold); transform:scale(1.3); }
.carousel-arrow {
  position:absolute; top:50%; transform:translateY(-50%); z-index:10;
  background:rgba(255,255,255,.2); border:none; color:#fff;
  width:36px; height:36px; border-radius:50%; cursor:pointer;
  font-size:14px; display:flex; align-items:center; justify-content:center;
  transition:.2s; backdrop-filter:blur(4px);
}
.carousel-arrow:hover { background:rgba(212,175,55,.6); }
.carousel-prev { left:12px; }
.carousel-next { right:12px; }

/* ── STATS BAR ── */
.stats-bar { background:var(--surface); border-bottom:1px solid var(--border); padding:24px 0; box-shadow:0 2px 8px rgba(0,0,0,.06); }
.stats-bar-inner { display:flex; justify-content:center; align-items:center; gap:0; flex-wrap:wrap; }
.stat-item { display:flex; align-items:center; gap:10px; padding:12px 32px; border-right:1px solid var(--border); }
.stat-item:last-child { border-right:none; }
.stat-item-icon { width:40px; height:40px; border-radius:9px; background:rgba(212,175,55,.1); color:var(--gold); display:flex; align-items:center; justify-content:center; font-size:16px; }
.stat-item-value { font-size:20px; font-weight:700; color:var(--text); line-height:1; }
.stat-item-label { font-size:12px; color:var(--text-muted); margin-top:2px; }

/* ── QUICK LINKS ── */
.quick-link-card {
  background:var(--surface); border:1px solid var(--border); border-radius:12px;
  padding:22px 20px; text-align:center; text-decoration:none;
  transition:all .2s; display:block;
}
.quick-link-card:hover { border-color:var(--gold); transform:translateY(-3px); box-shadow:0 8px 24px rgba(212,175,55,.12); }
.quick-link-icon {
  width:52px; height:52px; border-radius:12px;
  background:linear-gradient(135deg,var(--navy),#1e3a5f);
  display:flex; align-items:center; justify-content:center;
  color:var(--gold); font-size:20px; margin:0 auto 12px;
}
.quick-link-name { font-size:14px; font-weight:700; color:var(--text); margin-bottom:4px; }
.quick-link-desc { font-size:11px; color:var(--text-muted); line-height:1.5; }

/* ── SERVICES ── */
.service-card { background:var(--surface); border-radius:12px; border:1px solid var(--border); padding:28px 24px; text-align:center; transition:all .2s; }
.service-card:hover { border-color:var(--gold); transform:translateY(-3px); box-shadow:0 8px 24px rgba(212,175,55,.12); }
.service-icon { width:56px; height:56px; border-radius:14px; background:linear-gradient(135deg,var(--navy),#1e3a5f); display:flex; align-items:center; justify-content:center; color:var(--gold); font-size:22px; margin:0 auto 16px; }
.service-title { font-size:15px; font-weight:600; color:var(--text); margin-bottom:8px; }
.service-desc { font-size:13px; color:var(--text-muted); line-height:1.6; }

/* ── CTA ── */
.cta-section { background:linear-gradient(135deg,var(--navy) 0%,#1e3a5f 100%); padding:60px 0; text-align:center; position:relative; overflow:hidden; }
.cta-section::before { content:''; position:absolute; inset:0; background:url("{{ asset('assets/bg-dark.jpg') }}") center/cover; opacity:.05; }
.cta-section h2 { font-size:28px; font-weight:700; color:#fff; margin-bottom:10px; position:relative; }
.cta-section p { font-size:15px; color:rgba(255,255,255,.6); margin-bottom:28px; position:relative; }
.cta-btn-group { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; position:relative; }
</style>
@endpush

@section('content')

{{-- HERO --}}
<div class="hero-main">
  <div class="hero-content">
    <div class="hero-badge"><i class="fas fa-star"></i> Sistem Layanan Terintegrasi</div>
    <h1 class="hero-title">ONE <span class="accent">TOUCH</span><br>Balai PPMHKP Lampung</h1>
    <p class="hero-desc">
      Layanan sertifikasi mutu hasil perikanan yang cepat, transparan, dan terpercaya untuk mendukung ekspor perikanan Indonesia.
    </p>
    <div class="hero-cta">
      <a href="{{ route('layanan') }}" class="hero-btn hero-btn-primary">
        <i class="fas fa-list-check"></i> Mulai Layanan
      </a>
      <a href="{{ route('aplikasi') }}" class="hero-btn hero-btn-outline">
        <i class="fas fa-bullhorn"></i> Sampaikan Aspirasi
      </a>
    </div>
  </div>
</div>

{{-- PHOTO CAROUSEL --}}
<div class="carousel-wrap" id="carousel">
  <div class="carousel-track" id="carouselTrack">
    <div class="carousel-slide" style="background-image:linear-gradient(135deg,#0f172a 0%,#1e3a5f 100%)">
      <div class="slide-caption"><i class="fas fa-certificate" style="color:var(--gold)"></i> &nbsp;Sertifikasi Mutu Hasil Perikanan Unggulan Lampung</div>
    </div>
    <div class="carousel-slide" style="background-image:linear-gradient(135deg,#1e3a5f 0%,#0f4c2a 100%)">
      <div class="slide-caption"><i class="fas fa-ship" style="color:var(--gold)"></i> &nbsp;Mendukung Ekspor Produk Perikanan Indonesia</div>
    </div>
    <div class="carousel-slide" style="background-image:linear-gradient(135deg,#2d1b00 0%,#0f172a 100%)">
      <div class="slide-caption"><i class="fas fa-shield-halved" style="color:var(--gold)"></i> &nbsp;Inspeksi & Pengawasan Mutu Berstandar Internasional</div>
    </div>
    <div class="carousel-slide" style="background-image:linear-gradient(135deg,#1a0f2e 0%,#0f172a 100%)">
      <div class="slide-caption"><i class="fas fa-star-half-stroke" style="color:var(--gold)"></i> &nbsp;Survey Kepuasan Masyarakat — Komitmen Pelayanan Prima</div>
    </div>
  </div>
  <button class="carousel-arrow carousel-prev" onclick="carouselMove(-1)"><i class="fas fa-chevron-left"></i></button>
  <button class="carousel-arrow carousel-next" onclick="carouselMove(1)"><i class="fas fa-chevron-right"></i></button>
  <div class="carousel-dots" id="carouselDots"></div>
</div>

{{-- STATS BAR --}}
<div class="stats-bar">
  <div class="stats-bar-inner">
    <div class="stat-item">
      <div class="stat-item-icon"><i class="fas fa-certificate"></i></div>
      <div>
        <div class="stat-item-value">7+</div>
        <div class="stat-item-label">Jenis Layanan</div>
      </div>
    </div>
    <div class="stat-item">
      <div class="stat-item-icon"><i class="fas fa-ship"></i></div>
      <div>
        <div class="stat-item-value">{{ $latestEkspor ? number_format($latestEkspor->frekuensi) : '—' }}</div>
        <div class="stat-item-label">Frekuensi Ekspor (Bln Ini)</div>
      </div>
    </div>
    <div class="stat-item">
      <div class="stat-item-icon"><i class="fas fa-star-half-stroke"></i></div>
      <div>
        <div class="stat-item-value">{{ $latestSkm ? number_format($latestSkm->realisasi, 2) : '—' }}</div>
        <div class="stat-item-label">Nilai SKM Terkini</div>
      </div>
    </div>
    <div class="stat-item">
      <div class="stat-item-icon"><i class="fas fa-calendar"></i></div>
      <div>
        <div class="stat-item-value">{{ date('Y') }}</div>
        <div class="stat-item-label">Tahun Berjalan</div>
      </div>
    </div>
  </div>
</div>

{{-- QUICK LINKS --}}
<section class="section" style="background:var(--surface-2)">
  <div class="container">
    <div style="text-align:center; margin-bottom:32px">
      <div class="hero-badge" style="margin-bottom:10px"><i class="fas fa-bolt"></i> Akses Cepat</div>
      <h2 class="section-title">Layanan Digital Unggulan</h2>
      <p class="section-subtitle">Akses langsung sistem layanan digital Kementerian Kelautan dan Perikanan</p>
    </div>
    <div class="grid-4">
      <a href="https://siapmutu.kkp.go.id/login" target="_blank" class="quick-link-card">
        <div class="quick-link-icon"><i class="fas fa-award"></i></div>
        <div class="quick-link-name">SIAPMUTU</div>
        <div class="quick-link-desc">Sertifikasi Mutu Hasil Kelautan dan Perikanan untuk tujuan ekspor</div>
      </a>
      <a href="https://haccp.kkp.go.id/h4/login/" target="_blank" class="quick-link-card">
        <div class="quick-link-icon"><i class="fas fa-shield-halved"></i></div>
        <div class="quick-link-name">HONEST</div>
        <div class="quick-link-desc">HACCP Online System — Sistem Jaminan Keamanan Pangan</div>
      </a>
      <a href="https://skp-pdspkp.kkp.go.id/skp-online/auth/login" target="_blank" class="quick-link-card">
        <div class="quick-link-icon"><i class="fas fa-industry"></i></div>
        <div class="quick-link-name">SKP</div>
        <div class="quick-link-desc">Penerbitan Sertifikat Kelayakan Pengolahan</div>
      </a>
      <a href="https://oss.go.id/id" target="_blank" class="quick-link-card">
        <div class="quick-link-icon"><i class="fas fa-fish"></i></div>
        <div class="quick-link-name">OSS</div>
        <div class="quick-link-desc">Penerbitan Sertifikat CBIB, CPIB, CPIB Kapal</div>
      </a>
    </div>
  </div>
</section>

{{-- LAYANAN UTAMA --}}
<section class="section" style="background:var(--bg)">
  <div class="container">
    <div style="text-align:center; margin-bottom:36px">
      <div class="hero-badge" style="margin-bottom:10px"><i class="fas fa-shield-halved"></i> Layanan Kami</div>
      <h2 class="section-title">Jenis Sertifikasi yang Tersedia</h2>
      <p class="section-subtitle">Berbagai jenis sertifikasi mutu produk perikanan sesuai standar nasional dan internasional</p>
    </div>
    <div class="grid-3">
      @foreach([
        ['HACCP','Hazard Analysis Critical Control Points','fa-shield-halved'],
        ['SKP','Sertifikat Kelayakan Pengolahan','fa-industry'],
        ['CBIB','Cara Budidaya Ikan yang Baik','fa-fish'],
        ['CPIB','Cara Pembenihan Ikan yang Baik','fa-seedling'],
        ['HC','Health Certificate','fa-heart-pulse'],
        ['SPDI','Surat Penangkapan Ikan','fa-scroll'],
      ] as $svc)
      <div class="service-card">
        <div class="service-icon"><i class="fas {{ $svc[2] }}"></i></div>
        <div class="service-title">{{ $svc[0] }}</div>
        <div class="service-desc">{{ $svc[1] }}</div>
      </div>
      @endforeach
    </div>
    <div style="text-align:center; margin-top:28px">
      <a href="{{ route('layanan') }}" class="hero-btn hero-btn-primary" style="display:inline-flex">
        <i class="fas fa-arrow-right"></i> Lihat Semua Layanan
      </a>
    </div>
  </div>
</section>

{{-- CTA --}}
<div class="cta-section">
  <div class="container">
    <h2>Siap Mengakses Sistem?</h2>
    <p>Login untuk melihat status sertifikasi dan laporan Anda secara real-time.</p>
    <div class="cta-btn-group">
      <a href="{{ route('login') }}" class="hero-btn hero-btn-primary">
        <i class="fas fa-right-to-bracket"></i> Masuk ke Sistem ONE TOUCH
      </a>
      <a href="{{ route('aplikasi') }}" class="hero-btn hero-btn-outline">
        <i class="fas fa-bullhorn"></i> Sampaikan Aspirasi
      </a>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
(function(){
  const track = document.getElementById('carouselTrack');
  const dotsWrap = document.getElementById('carouselDots');
  const slides = track.children.length;
  let current = 0;
  let timer;

  // Build dots
  for(let i=0;i<slides;i++){
    const d = document.createElement('button');
    d.className = 'carousel-dot' + (i===0?' active':'');
    d.onclick = () => goTo(i);
    dotsWrap.appendChild(d);
  }

  function goTo(n){
    current = (n + slides) % slides;
    track.style.transform = 'translateX(-' + (current * 100) + '%)';
    document.querySelectorAll('.carousel-dot').forEach((d,i) => d.classList.toggle('active', i===current));
  }

  window.carouselMove = function(dir){ goTo(current + dir); resetTimer(); };

  function resetTimer(){ clearInterval(timer); timer = setInterval(() => goTo(current+1), 4500); }
  resetTimer();
})();
</script>
@endpush
