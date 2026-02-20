@extends('layouts.public')
@section('title', 'Layanan')
@push('styles')
<style>
.page-hero { background:var(--navy); padding:56px 0 48px; text-align:center; position:relative; overflow:hidden; }
.page-hero::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(15,23,42,.95),rgba(30,58,95,.8)); }
.page-hero-content { position:relative; z-index:1; }
.page-hero h1 { font-size:clamp(24px,4vw,40px); font-weight:800; color:#fff; margin-bottom:8px; }
.page-hero p { font-size:15px; color:rgba(255,255,255,.6); max-width:520px; margin:0 auto; }
.page-badge { display:inline-flex; align-items:center; gap:6px; background:rgba(212,175,55,.15); border:1px solid rgba(212,175,55,.3); color:var(--gold); padding:5px 14px; border-radius:20px; font-size:11px; font-weight:600; margin-bottom:14px; }

.svc-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; transition:all .25s; }
.svc-card:hover { border-color:var(--gold); box-shadow:0 12px 32px rgba(212,175,55,.1); transform:translateY(-4px); }
.svc-card-header { background:linear-gradient(135deg,var(--navy),#1e3a5f); padding:28px 24px; display:flex; align-items:center; gap:16px; }
.svc-card-icon { width:52px; height:52px; background:rgba(212,175,55,.15); border-radius:12px; display:flex; align-items:center; justify-content:center; color:var(--gold); font-size:22px; flex-shrink:0; }
.svc-card-name { font-size:18px; font-weight:700; color:#fff; }
.svc-card-fullname { font-size:12px; color:rgba(255,255,255,.55); margin-top:3px; line-height:1.4; }
.svc-card-body { padding:20px 24px; }
.svc-card-desc { font-size:13px; color:var(--text-muted); line-height:1.7; margin-bottom:16px; }
.svc-links { display:flex; gap:8px; flex-wrap:wrap; }
.svc-link-btn {
  display:inline-flex; align-items:center; gap:6px;
  padding:7px 14px; border-radius:8px; font-size:12px; font-weight:600;
  text-decoration:none; transition:all .2s;
}
.svc-link-access { background:var(--gold); color:var(--navy); }
.svc-link-access:hover { background:#c09b28; }
.svc-link-reg { background:var(--surface-2); border:1px solid var(--border); color:var(--text); }
.svc-link-reg:hover { border-color:var(--gold); color:var(--gold); }
.svc-link-none { color:var(--text-muted); font-style:italic; font-size:12px; padding:7px 0; }
</style>
@endpush

@section('content')
<div class="page-hero">
  <div class="container page-hero-content">
    <div class="page-badge"><i class="fas fa-list-check"></i> Layanan Digital</div>
    <h1>Layanan BALAI PPMHKP LAMPUNG</h1>
    <p>Sistem layanan digital terintegrasi untuk sertifikasi mutu hasil kelautan dan perikanan</p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(340px,1fr)); gap:24px">

      {{-- SIAPMUTU --}}
      <div class="svc-card">
        <div class="svc-card-header">
          <div class="svc-card-icon"><i class="fas fa-award"></i></div>
          <div>
            <div class="svc-card-name">SIAPMUTU</div>
            <div class="svc-card-fullname">Sertifikasi Mutu Hasil Kelautan dan Perikanan untuk tujuan ekspor</div>
          </div>
        </div>
        <div class="svc-card-body">
          <p class="svc-card-desc">Sistem informasi untuk pengurusan sertifikat mutu produk perikanan yang akan diekspor. Memudahkan proses pengajuan, verifikasi, dan penerbitan sertifikat secara online.</p>
          <div class="svc-links">
            <a href="https://siapmutu.kkp.go.id/login" target="_blank" class="svc-link-btn svc-link-access"><i class="fas fa-external-link-alt"></i> Akses Sistem</a>
            <a href="https://drive.google.com/drive/folders/1NVkJWWvtIHhnWkBonIzUxjZhujMD9EQy?usp=drive_link" target="_blank" class="svc-link-btn svc-link-reg"><i class="fas fa-folder-open"></i> Regulasi</a>
          </div>
        </div>
      </div>

      {{-- HONEST --}}
      <div class="svc-card">
        <div class="svc-card-header">
          <div class="svc-card-icon"><i class="fas fa-shield-halved"></i></div>
          <div>
            <div class="svc-card-name">HONEST</div>
            <div class="svc-card-fullname">HACCP Online System</div>
          </div>
        </div>
        <div class="svc-card-body">
          <p class="svc-card-desc">Sistem online untuk penerapan Hazard Analysis Critical Control Points (HACCP) — standar keamanan pangan internasional bagi unit pengolahan ikan.</p>
          <div class="svc-links">
            <a href="https://haccp.kkp.go.id/h4/login/" target="_blank" class="svc-link-btn svc-link-access"><i class="fas fa-external-link-alt"></i> Akses Sistem</a>
            <a href="https://drive.google.com/drive/folders/1vMZdXV1epqd5BnrWj7z3jXr9sxHKuaq7?usp=drive_link" target="_blank" class="svc-link-btn svc-link-reg"><i class="fas fa-folder-open"></i> Regulasi</a>
          </div>
        </div>
      </div>

      {{-- SKP --}}
      <div class="svc-card">
        <div class="svc-card-header">
          <div class="svc-card-icon"><i class="fas fa-industry"></i></div>
          <div>
            <div class="svc-card-name">SKP</div>
            <div class="svc-card-fullname">Penerbitan Sertifikat Kelayakan Pengolahan</div>
          </div>
        </div>
        <div class="svc-card-body">
          <p class="svc-card-desc">Sistem untuk pengajuan dan penerbitan Sertifikat Kelayakan Pengolahan (SKP) bagi unit pengolahan ikan yang memenuhi standar persyaratan teknis sanitasi dan higiene.</p>
          <div class="svc-links">
            <a href="https://skp-pdspkp.kkp.go.id/skp-online/auth/login" target="_blank" class="svc-link-btn svc-link-access"><i class="fas fa-external-link-alt"></i> Akses Sistem</a>
            <a href="https://drive.google.com/drive/folders/18lvCabQOEHb4gm4TGC9H5Vry3_2FGqcG?usp=drive_link" target="_blank" class="svc-link-btn svc-link-reg"><i class="fas fa-folder-open"></i> Regulasi</a>
          </div>
        </div>
      </div>

      {{-- OSS --}}
      <div class="svc-card">
        <div class="svc-card-header">
          <div class="svc-card-icon"><i class="fas fa-fish"></i></div>
          <div>
            <div class="svc-card-name">OSS</div>
            <div class="svc-card-fullname">Penerbitan Sertifikat CBIB, CPIB, CPIB Kapal</div>
          </div>
        </div>
        <div class="svc-card-body">
          <p class="svc-card-desc">Online Single Submission — sistem perizinan berusaha terintegrasi untuk penerbitan sertifikat Cara Budidaya Ikan yang Baik (CBIB), Cara Pembenihan Ikan yang Baik (CPIB), dan CPIB Kapal.</p>
          <div class="svc-links">
            <a href="https://oss.go.id/id" target="_blank" class="svc-link-btn svc-link-access"><i class="fas fa-external-link-alt"></i> Akses Sistem</a>
            <a href="https://drive.google.com/drive/folders/11-Xbqw6iciOsMRjillsM6H6vb93tcYp7?usp=drive_link" target="_blank" class="svc-link-btn svc-link-reg"><i class="fas fa-folder-open"></i> Regulasi</a>
          </div>
        </div>
      </div>

      {{-- SIMONA --}}
      <div class="svc-card">
        <div class="svc-card-header">
          <div class="svc-card-icon"><i class="fas fa-chart-bar"></i></div>
          <div>
            <div class="svc-card-name">SIMONA</div>
            <div class="svc-card-fullname">Monitoring Realisasi Anggaran</div>
          </div>
        </div>
        <div class="svc-card-body">
          <p class="svc-card-desc">Sistem Informasi Monitoring Anggaran (SIMONA) untuk pemantauan dan pelaporan realisasi anggaran secara real-time di lingkungan KKP.</p>
          <div class="svc-links">
            <a href="https://siapmutu.kkp.go.id/simona/login" target="_blank" class="svc-link-btn svc-link-access"><i class="fas fa-external-link-alt"></i> Akses Sistem</a>
            <span class="svc-link-none"><i class="fas fa-minus-circle"></i> Regulasi belum tersedia</span>
          </div>
        </div>
      </div>

      {{-- SILAB --}}
      <div class="svc-card">
        <div class="svc-card-header">
          <div class="svc-card-icon"><i class="fas fa-flask"></i></div>
          <div>
            <div class="svc-card-name">SILAB</div>
            <div class="svc-card-fullname">Sistem Pengendalian Bahan Laboratorium</div>
          </div>
        </div>
        <div class="svc-card-body">
          <p class="svc-card-desc">Sistem untuk pengelolaan dan pengendalian bahan laboratorium di lingkungan Balai PPMHKP, mendukung kegiatan pengujian mutu hasil perikanan.</p>
          <div class="svc-links">
            <a href="https://siapmutu.kkp.go.id/silab/" target="_blank" class="svc-link-btn svc-link-access"><i class="fas fa-external-link-alt"></i> Akses Sistem</a>
            <span class="svc-link-none"><i class="fas fa-minus-circle"></i> Regulasi belum tersedia</span>
          </div>
        </div>
      </div>

      {{-- REGMITRA --}}
      <div class="svc-card">
        <div class="svc-card-header">
          <div class="svc-card-icon"><i class="fas fa-globe"></i></div>
          <div>
            <div class="svc-card-name">REGMITRA</div>
            <div class="svc-card-fullname">Registrasi Negara Mitra</div>
          </div>
        </div>
        <div class="svc-card-body">
          <p class="svc-card-desc">Sistem untuk registrasi dan pengelolaan data negara mitra tujuan ekspor produk perikanan Indonesia, memastikan kepatuhan terhadap persyaratan negara tujuan.</p>
          <div class="svc-links">
            <a href="https://siapmutu.kkp.go.id/ppk/" target="_blank" class="svc-link-btn svc-link-access"><i class="fas fa-external-link-alt"></i> Akses Sistem</a>
            <span class="svc-link-none"><i class="fas fa-minus-circle"></i> Regulasi belum tersedia</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
