@extends('layouts.public')
@section('title', 'Regulasi')
@push('styles')
<style>
.page-hero { background:var(--navy); padding:56px 0 48px; text-align:center; position:relative; overflow:hidden; }
.page-hero::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(15,23,42,.95),rgba(30,58,95,.8)); }
.page-hero-content { position:relative; z-index:1; }
.page-hero h1 { font-size:clamp(24px,4vw,40px); font-weight:800; color:#fff; margin-bottom:8px; }
.page-hero p { font-size:15px; color:rgba(255,255,255,.6); max-width:520px; margin:0 auto; }
.page-badge { display:inline-flex; align-items:center; gap:6px; background:rgba(212,175,55,.15); border:1px solid rgba(212,175,55,.3); color:var(--gold); padding:5px 14px; border-radius:20px; font-size:11px; font-weight:600; margin-bottom:14px; }

.reg-group { margin-bottom:40px; }
.reg-group-title { font-size:17px; font-weight:700; color:var(--text); margin-bottom:4px; display:flex; align-items:center; gap:8px; }
.reg-divider { height:2px; background:linear-gradient(to right,var(--gold),transparent); margin-bottom:16px; margin-top:8px; }
.reg-list { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:12px; }
.reg-item {
  background:var(--surface); border:1px solid var(--border); border-radius:10px;
  padding:16px 18px; display:flex; align-items:flex-start; gap:12px;
  text-decoration:none; transition:all .2s;
}
.reg-item:hover { border-color:var(--gold); transform:translateX(2px); box-shadow:0 4px 16px rgba(212,175,55,.08); }
.reg-item-icon { width:36px; height:36px; border-radius:8px; background:rgba(212,175,55,.1); display:flex; align-items:center; justify-content:center; color:var(--gold); font-size:14px; flex-shrink:0; }
.reg-item-name { font-size:13px; font-weight:600; color:var(--text); margin-bottom:2px; }
.reg-item-desc { font-size:11px; color:var(--text-muted); }
.reg-item-arrow { margin-left:auto; color:var(--text-muted); font-size:12px; flex-shrink:0; padding-top:2px; }
</style>
@endpush

@section('content')
<div class="page-hero">
  <div class="container page-hero-content">
    <div class="page-badge"><i class="fas fa-scroll"></i> Regulasi & Kebijakan</div>
    <h1>Regulasi BALAI PPMHKP  Lampung</h1>
    <p>Dokumen regulasi, kebijakan, dan peraturan yang menjadi dasar layanan dan tata kelola BALAI PPMHKP  Lampung</p>
  </div>
</div>

<section class="section">
  <div class="container">

    {{-- Regulasi Sertifikasi --}}
    <div class="reg-group">
      <div class="reg-group-title"><i class="fas fa-certificate" style="color:var(--gold)"></i> Regulasi Sertifikasi Mutu</div>
      <div class="reg-divider"></div>
      <div class="reg-list">
        <a href="https://drive.google.com/drive/folders/1NVkJWWvtIHhnWkBonIzUxjZhujMD9EQy?usp=drive_link" target="_blank" class="reg-item">
          <div class="reg-item-icon"><i class="fas fa-folder-open"></i></div>
          <div>
            <div class="reg-item-name">Regulasi SIAPMUTU</div>
            <div class="reg-item-desc">Peraturan sertifikasi mutu hasil kelautan dan perikanan untuk ekspor</div>
          </div>
          <div class="reg-item-arrow"><i class="fas fa-external-link-alt"></i></div>
        </a>
        <a href="https://drive.google.com/drive/folders/1vMZdXV1epqd5BnrWj7z3jXr9sxHKuaq7?usp=drive_link" target="_blank" class="reg-item">
          <div class="reg-item-icon"><i class="fas fa-folder-open"></i></div>
          <div>
            <div class="reg-item-name">Regulasi HACCP / HONEST</div>
            <div class="reg-item-desc">Peraturan penerapan Hazard Analysis Critical Control Points</div>
          </div>
          <div class="reg-item-arrow"><i class="fas fa-external-link-alt"></i></div>
        </a>
        <a href="https://drive.google.com/drive/folders/18lvCabQOEHb4gm4TGC9H5Vry3_2FGqcG?usp=drive_link" target="_blank" class="reg-item">
          <div class="reg-item-icon"><i class="fas fa-folder-open"></i></div>
          <div>
            <div class="reg-item-name">Regulasi SKP</div>
            <div class="reg-item-desc">Peraturan penerbitan Sertifikat Kelayakan Pengolahan</div>
          </div>
          <div class="reg-item-arrow"><i class="fas fa-external-link-alt"></i></div>
        </a>
        <a href="https://drive.google.com/drive/folders/11-Xbqw6iciOsMRjillsM6H6vb93tcYp7?usp=drive_link" target="_blank" class="reg-item">
          <div class="reg-item-icon"><i class="fas fa-folder-open"></i></div>
          <div>
            <div class="reg-item-name">Regulasi CBIB / CPIB (OSS)</div>
            <div class="reg-item-desc">Peraturan penerbitan sertifikat budidaya dan pembenihan ikan</div>
          </div>
          <div class="reg-item-arrow"><i class="fas fa-external-link-alt"></i></div>
        </a>
      </div>
    </div>

    {{-- Regulasi Hukum --}}
    <div class="reg-group">
      <div class="reg-group-title"><i class="fas fa-book" style="color:var(--gold)"></i> Hukum & Peraturan Perundangan</div>
      <div class="reg-divider"></div>
      <div class="reg-list">
        <a href="https://jdih.kkp.go.id/" target="_blank" class="reg-item">
          <div class="reg-item-icon"><i class="fas fa-balance-scale"></i></div>
          <div>
            <div class="reg-item-name">JDIH KKP</div>
            <div class="reg-item-desc">Jaringan Dokumentasi & Informasi Hukum Kementerian KKP</div>
          </div>
          <div class="reg-item-arrow"><i class="fas fa-external-link-alt"></i></div>
        </a>
        <a href="https://ppid.kkp.go.id/upt/balai-kipm-lampung/" target="_blank" class="reg-item">
          <div class="reg-item-icon"><i class="fas fa-file-circle-info"></i></div>
          <div>
            <div class="reg-item-name">Informasi Publik PPID</div>
            <div class="reg-item-desc">Dokumen dan informasi publik resmi BALAI PPMHKP  Lampung</div>
          </div>
          <div class="reg-item-arrow"><i class="fas fa-external-link-alt"></i></div>
        </a>
      </div>
    </div>

    {{-- Info box --}}
    <div style="background:rgba(212,175,55,.06); border:1px solid rgba(212,175,55,.2); border-radius:12px; padding:20px 24px; display:flex; gap:14px; align-items:flex-start;">
      <i class="fas fa-circle-info" style="color:var(--gold); font-size:20px; flex-shrink:0; margin-top:2px"></i>
      <div>
        <div style="font-weight:600; color:var(--text); margin-bottom:4px">Butuh Dokumen Regulasi Lainnya?</div>
        <div style="font-size:13px; color:var(--text-muted); line-height:1.7">
          Hubungi kami melalui WhatsApp <a href="https://api.whatsapp.com/send/?phone=%2B62816245342" target="_blank" style="color:var(--gold); font-weight:600">Whatsapp</a> atau kunjungi kantor Balai PPMHKP Lampung untuk memperoleh dokumen regulasi yang dibutuhkan.
        </div>
      </div>
    </div>

  </div>
</section>
@endsection
