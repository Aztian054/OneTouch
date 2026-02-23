@extends('layouts.public')
@section('title', 'Media & Berita')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@push('styles')
<style>
.page-hero { background:var(--navy); padding:56px 0 48px; text-align:center; position:relative; overflow:hidden; }
.page-hero::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(15,23,42,.95),rgba(30,58,95,.8)); }
.page-hero-content { position:relative; z-index:1; }
.page-hero h1 { font-size:clamp(24px,4vw,40px); font-weight:800; color:#fff; margin-bottom:8px; }
.page-hero p { font-size:15px; color:rgba(255,255,255,.6); max-width:520px; margin:0 auto; }
.page-badge { display:inline-flex; align-items:center; gap:6px; background:rgba(212,175,55,.15); border:1px solid rgba(212,175,55,.3); color:var(--gold); padding:5px 14px; border-radius:20px; font-size:11px; font-weight:600; margin-bottom:14px; }
.section-heading { font-size:22px; font-weight:700; color:var(--text); margin-bottom:6px; }
.section-sub { font-size:13px; color:var(--text-muted); margin-bottom:24px; }

/* SOSMED */
.sosmed-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:16px; }
.sosmed-card {
  background:var(--surface); border:1px solid var(--border); border-radius:14px;
  padding:24px 16px; text-align:center; text-decoration:none; transition:all .25s;
  display:flex; flex-direction:column; align-items:center; gap:10px;
}
.sosmed-card:hover { transform:translateY(-4px); box-shadow:0 10px 28px rgba(0,0,0,.1); }
.sosmed-icon { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; color:#fff; }
.sosmed-name { font-size:13px; font-weight:600; color:var(--text); }
.sosmed-handle { font-size:11px; color:var(--text-muted); }

/* NEWS GRID */
.news-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:20px; }
.news-card { background:var(--surface); border:1px solid var(--border); border-radius:14px; overflow:hidden; transition:all .2s; }
.news-card:hover { border-color:var(--gold); transform:translateY(-3px); box-shadow:0 8px 24px rgba(212,175,55,.1); }
.news-thumb { height:160px; background:center/cover no-repeat; }
.news-body { padding:18px; }
.news-tag { font-size:10px; font-weight:700; color:var(--gold); text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px; }
.news-title { font-size:14px; font-weight:600; color:var(--text); line-height:1.5; margin-bottom:8px; }
.news-date { font-size:11px; color:var(--text-muted); }
</style>
@endpush

@section('content')
<div class="page-hero">
  <div class="container page-hero-content">
    <div class="page-badge"><i class="fas fa-newspaper"></i> Media & Sosial</div>
    <h1>Media Sosial & Berita Kegiatan</h1>
    <p>Ikuti perkembangan terkini kegiatan dan layanan BALAI PPMHKP Lampung di media sosial</p>
  </div>
</div>

<section class="section">
  <div class="container">

    {{-- SOCIAL MEDIA --}}
    <div class="section-heading"><i class="fas fa-share-nodes" style="color:var(--gold)"></i> Media Sosial</div>
    <p class="section-sub">Ikuti kami di berbagai platform media sosial untuk informasi terkini</p>
    <div class="sosmed-grid" style="margin-bottom:56px">

      <a href="https://instagram.com/badanmutukkplampung?igsh=MXh0ZGJ0ZHl0OTd4eA==" target="_blank" class="sosmed-card">
        <div class="sosmed-icon" style="background:linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888)">
          <i class="fab fa-instagram"></i>
        </div>
        <div class="sosmed-name">Instagram</div>
        <div class="sosmed-handle">@badanmutukkplampung</div>
      </a>

      <a href="https://www.youtube.com/@badanmutukkplampung?si=ioJrOdKFUyzWCZac" target="_blank" class="sosmed-card">
        <div class="sosmed-icon" style="background:#ff0000">
          <i class="fab fa-youtube"></i>
        </div>
        <div class="sosmed-name">YouTube</div>
        <div class="sosmed-handle">@badanmutukkplampung</div>
      </a>

      <a href="https://x.com/BPPMHKPLampung" target="_blank" class="sosmed-card">
        <div class="sosmed-icon" style="background:#000">
          <i class="fab fa-x-twitter"></i>
        </div>
        <div class="sosmed-name">X / Twitter</div>
        <div class="sosmed-handle">@BALAI PPMHKP Lampung</div>
      </a>

      <a href="https://api.whatsapp.com/send/?phone=%2B62816245342&text&type=phone_number&app_absent=0" target="_blank" class="sosmed-card">
        <div class="sosmed-icon" style="background:#25d366">
          <i class="fab fa-whatsapp"></i>
        </div>
        <div class="sosmed-name">WhatsApp</div>
        <div class="sosmed-handle">@BALAI PPMHKP lampung</div>
      </a>

      <a href="https://www.threads.com/@badanmutukkplampung?hl=en" target="_blank" class="sosmed-card">
        <div class="sosmed-icon" style="background:#000">
          <i class="fab fa-threads"></i>
        </div>
        <div class="sosmed-name">Threads</div>
        <div class="sosmed-handle">@BALAI PPMHKP lampung</div>
      </a>

      <a href="https://www.tiktok.com/@bppmhkplampung" target="_blank" class="sosmed-card">
        <div class="sosmed-icon" style="background:#010101">
          <i class="fab fa-tiktok"></i>
        </div>
        <div class="sosmed-name">TikTok</div>
        <div class="sosmed-handle">@BALAI PPMHKP lampung</div>
      </a>

    </div>

    {{-- NEWS / KEGIATAN --}}
    <div class="section-heading"><i class="fas fa-newspaper" style="color:var(--gold)"></i> Berita & Kegiatan</div>
    <p class="section-sub">Informasi terbaru kegiatan inspeksi, sertifikasi, dan program BALAI PPMHKP  Lampung</p>

    <div class="news-grid">
      @php
        $newsItems = \App\Models\News::active()->ordered()->take(6)->get();
      @endphp
      @forelse($newsItems as $item)
      <div class="news-card">
        <div class="news-thumb" style="background-image:url('{{ $item->image ? asset($item->image) : 'data:image/svg+xml,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><rect fill="%231e293b" width="100%" height="100%"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="%23d4af37" font-family="Arial" font-size="40">📰</text></svg>'); }}'); display:flex; align-items:center; justify-content:center;">
          @if(!$item->image)
          <i class="fas fa-newspaper" style="font-size:40px; color:rgba(212,175,55,.3)"></i>
          @endif
        </div>
        <div class="news-body">
          <div class="news-tag">{{ $item->event_date ? $item->event_date->format('d M Y') : 'Berita' }}</div>
          <div class="news-title">{{ $item->title }}</div>
          <div class="news-date"><i class="fas fa-calendar-alt" style="color:var(--gold); margin-right:4px"></i>{{ $item->event_date ? $item->event_date->isoFormat('D MMMM Y') : 'Belum ada tanggal' }}</div>
        </div>
      </div>
      @empty
      <div style="grid-column: 1/-1; text-align:center; color:var(--text-muted); padding:40px;">Belum ada berita</div>
      @endforelse
    </div>

  </div>
</section>
@endsection
