@extends('layouts.public')
@section('title', 'Aplikasi')
@push('styles')
<style>
.page-hero { background:var(--navy); padding:56px 0 48px; text-align:center; position:relative; overflow:hidden; }
.page-hero::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(15,23,42,.95),rgba(30,58,95,.8)); }
.page-hero-content { position:relative; z-index:1; }
.page-hero h1 { font-size:clamp(24px,4vw,40px); font-weight:800; color:#fff; margin-bottom:8px; }
.page-hero p { font-size:15px; color:rgba(255,255,255,.6); max-width:520px; margin:0 auto; }
.page-badge { display:inline-flex; align-items:center; gap:6px; background:rgba(212,175,55,.15); border:1px solid rgba(212,175,55,.3); color:var(--gold); padding:5px 14px; border-radius:20px; font-size:11px; font-weight:600; margin-bottom:14px; }

.app-group { margin-bottom:48px; }
.app-group-title {
  display:flex; align-items:center; gap:10px;
  font-size:18px; font-weight:700; color:var(--text);
  margin-bottom:6px;
}
.app-group-title-icon { width:36px; height:36px; border-radius:9px; background:var(--navy); display:flex; align-items:center; justify-content:center; color:var(--gold); font-size:14px; flex-shrink:0; }
.app-group-desc { font-size:13px; color:var(--text-muted); margin-bottom:18px; padding-left:46px; }

.app-cards { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:14px; }
.app-card {
  background:var(--surface); border:1px solid var(--border); border-radius:12px;
  padding:18px 20px; display:flex; align-items:flex-start; gap:14px;
  text-decoration:none; transition:all .2s;
}
.app-card:hover { border-color:var(--gold); transform:translateY(-2px); box-shadow:0 6px 20px rgba(212,175,55,.1); }
.app-card-icon { width:42px; height:42px; border-radius:10px; background:linear-gradient(135deg,var(--navy),#1e3a5f); display:flex; align-items:center; justify-content:center; color:var(--gold); font-size:17px; flex-shrink:0; }
.app-card-name { font-size:14px; font-weight:600; color:var(--text); margin-bottom:3px; }
.app-card-desc { font-size:12px; color:var(--text-muted); line-height:1.5; }
.app-card-arrow { margin-left:auto; color:var(--text-muted); font-size:12px; padding-top:4px; flex-shrink:0; }
</style>
@endpush

@section('content')
<div class="page-hero">
  <div class="container page-hero-content">
    <div class="page-badge"><i class="fas fa-grid-2"></i> Aplikasi Digital</div>
    <h1>Aplikasi Layanan Digital</h1>
    <p>Kumpulan aplikasi layanan digital BPPMHKP Lampung — survey, pengaduan, informasi, dan layanan tamu</p>
  </div>
</div>

<section class="section">
  <div class="container">

    {{-- Survey --}}
    <div class="app-group">
      <div class="app-group-title">
        <div class="app-group-title-icon"><i class="fas fa-star-half-stroke"></i></div>
        Survey Layanan Masyarakat
      </div>
      <p class="app-group-desc">Berikan penilaian dan masukan atas kualitas pelayanan yang telah Anda terima.</p>
      <div class="app-cards">
        <a href="https://ptsp.kkp.go.id/skm/s/u/46" target="_blank" class="app-card">
          <div class="app-card-icon"><i class="fas fa-poll"></i></div>
          <div>
            <div class="app-card-name">Survey Kepuasan Masyarakat</div>
            <div class="app-card-desc">Formulir IKM online BPPMHKP Lampung — sampaikan penilaian Anda terhadap layanan kami</div>
          </div>
          <div class="app-card-arrow"><i class="fas fa-external-link-alt"></i></div>
        </a>
      </div>
    </div>

    {{-- Pengaduan --}}
    <div class="app-group">
      <div class="app-group-title">
        <div class="app-group-title-icon"><i class="fas fa-bullhorn"></i></div>
        Layanan Pengaduan & Aspirasi
      </div>
      <p class="app-group-desc">Sampaikan pengaduan, saran, dan aspirasi Anda melalui kanal pengaduan resmi.</p>
      <div class="app-cards">
        <a href="https://gol.kpk.go.id/" target="_blank" class="app-card">
          <div class="app-card-icon"><i class="fas fa-gavel"></i></div>
          <div>
            <div class="app-card-name">GOL KPK</div>
            <div class="app-card-desc">Gratifikasi Online — laporkan gratifikasi kepada KPK secara online</div>
          </div>
          <div class="app-card-arrow"><i class="fas fa-external-link-alt"></i></div>
        </a>
        <a href="https://upg.kkp.go.id/" target="_blank" class="app-card">
          <div class="app-card-icon"><i class="fas fa-comments"></i></div>
          <div>
            <div class="app-card-name">UPG KKP</div>
            <div class="app-card-desc">Unit Pengendali Gratifikasi KKP — layanan pengaduan dan aspirasi masyarakat KKP</div>
          </div>
          <div class="app-card-arrow"><i class="fas fa-external-link-alt"></i></div>
        </a>
      </div>
    </div>

    {{-- Informasi --}}
    <div class="app-group">
      <div class="app-group-title">
        <div class="app-group-title-icon"><i class="fas fa-circle-info"></i></div>
        Layanan Informasi
      </div>
      <p class="app-group-desc">Akses informasi publik, peraturan, dan kebijakan kelautan dan perikanan.</p>
      <div class="app-cards">
        <a href="https://ppid.kkp.go.id/upt/balai-kipm-lampung/" target="_blank" class="app-card">
          <div class="app-card-icon"><i class="fas fa-file-circle-info"></i></div>
          <div>
            <div class="app-card-name">PPID KKP Lampung</div>
            <div class="app-card-desc">Pejabat Pengelola Informasi & Dokumentasi — akses informasi publik resmi</div>
          </div>
          <div class="app-card-arrow"><i class="fas fa-external-link-alt"></i></div>
        </a>
        <a href="https://jdih.kkp.go.id/" target="_blank" class="app-card">
          <div class="app-card-icon"><i class="fas fa-book"></i></div>
          <div>
            <div class="app-card-name">JDIH KKP</div>
            <div class="app-card-desc">Jaringan Dokumentasi & Informasi Hukum — peraturan dan regulasi KKP lengkap</div>
          </div>
          <div class="app-card-arrow"><i class="fas fa-external-link-alt"></i></div>
        </a>
      </div>
    </div>

    {{-- Smart Guest --}}
    <div class="app-group">
      <div class="app-group-title">
        <div class="app-group-title-icon"><i class="fas fa-user-check"></i></div>
        Layanan Smart Guest
      </div>
      <p class="app-group-desc">Pendaftaran dan manajemen tamu digital berbasis aplikasi mobile.</p>
      <div class="app-cards">
        <a href="https://www.appsheet.com/start/a72f4794-790e-4927-aa4c-bde324630c6b" target="_blank" class="app-card">
          <div class="app-card-icon"><i class="fas fa-qrcode"></i></div>
          <div>
            <div class="app-card-name">Smart Guest BPPMHKP</div>
            <div class="app-card-desc">Sistem pendaftaran tamu digital — daftarkan kunjungan Anda secara mandiri</div>
          </div>
          <div class="app-card-arrow"><i class="fas fa-external-link-alt"></i></div>
        </a>
      </div>
    </div>

  </div>
</section>
@endsection
