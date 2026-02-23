@extends('layouts.public')
@section('title', 'Tentang Kami')
@push('styles')
<style>
.page-hero { background:var(--navy); padding:56px 0 48px; text-align:center; position:relative; overflow:hidden; }
.page-hero::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(15,23,42,.95),rgba(30,58,95,.8)); }
.page-hero-content { position:relative; z-index:1; }
.page-hero h1 { font-size:clamp(24px,4vw,40px); font-weight:800; color:#fff; margin-bottom:8px; }
.page-hero p { font-size:15px; color:rgba(255,255,255,.6); max-width:520px; margin:0 auto; }
.page-badge { display:inline-flex; align-items:center; gap:6px; background:rgba(212,175,55,.15); border:1px solid rgba(212,175,55,.3); color:var(--gold); padding:5px 14px; border-radius:20px; font-size:11px; font-weight:600; margin-bottom:14px; }

/* Section heading */
.about-h { font-size:18px; font-weight:700; color:var(--text); margin-bottom:4px; display:flex; align-items:center; gap:8px; }
.about-divider { height:2px; background:linear-gradient(to right,var(--gold),transparent); margin:8px 0 20px; }

/* Card */
.about-card { background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:28px 28px; margin-bottom:24px; }

/* Visi Misi */
.vm-box { background:var(--surface-2); border-left:3px solid var(--gold); border-radius:0 10px 10px 0; padding:18px 22px; margin-bottom:16px; font-size:14px; color:var(--text); line-height:1.8; }
.vm-label { font-size:11px; font-weight:700; color:var(--gold); text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px; }

/* List */
.about-list { list-style:none; padding:0; margin:0; }
.about-list li { display:flex; gap:10px; align-items:flex-start; padding:10px 0; border-bottom:1px solid var(--border); font-size:13px; color:var(--text-muted); line-height:1.6; }
.about-list li:last-child { border-bottom:none; }
.about-list li::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--gold); flex-shrink:0; margin-top:7px; }

/* Fungsi list */
.fungsi-list { counter-reset:fungsi; list-style:none; padding:0; margin:0; }
.fungsi-list li { display:flex; gap:12px; align-items:flex-start; padding:10px 0; border-bottom:1px solid var(--border); font-size:13px; color:var(--text-muted); line-height:1.6; }
.fungsi-list li:last-child { border-bottom:none; }
.fungsi-list li::before { counter-increment:fungsi; content:counter(fungsi); width:22px; height:22px; border-radius:50%; background:var(--navy); color:var(--gold); font-size:11px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }

/* Org chart placeholder */
.org-placeholder { background:var(--surface-2); border:2px dashed var(--border); border-radius:12px; padding:40px; text-align:center; color:var(--text-muted); }

/* Map */
.map-wrap { border-radius:12px; overflow:hidden; border:1px solid var(--border); }
.map-wrap iframe { display:block; width:100%; height:400px; border:none; }
</style>
@endpush

@section('content')
<div class="page-hero">
  <div class="container page-hero-content">
    <div class="page-badge"><i class="fas fa-building-columns"></i> Profil Organisasi</div>
    <h1>Tentang BALAI PPMHKP  Lampung</h1>
    <p>Balai Pengendalian dan Pengawasan Mutu dan Keamanan Hasil Kelautan dan Perikanan Lampung</p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:28px; align-items:start">

      {{-- LEFT COLUMN --}}
      <div>

        {{-- Visi --}}
        <div class="about-card">
          <div class="about-h"><i class="fas fa-eye" style="color:var(--gold)"></i> Visi</div>
          <div class="about-divider"></div>
          <div class="vm-box">
            <div class="vm-label">Visi Organisasi</div>
            Terselenggaranya pengendalian dan pengawasan mutu yang terdepan untuk memastikan keamanan, kualitas, keberlanjutan dan daya saing hasil kelautan dan perikanan, dalam rangka mewujudkan masyarakat kelautan dan perikanan yang sejahtera dan sumber daya kelautan dan perikanan yang berkelanjutan untuk Indonesia maju yang berdaulat, mandiri, berkepribadian, berlandaskan gotong royong.
          </div>
        </div>

        {{-- Misi --}}
        <div class="about-card">
          <div class="about-h"><i class="fas fa-bullseye" style="color:var(--gold)"></i> Misi</div>
          <div class="about-divider"></div>
          <ul class="about-list">
            <li>Meningkatkan daya saing hasil kelautan dan perikanan melalui inspeksi, sertifikasi, surveilans, pengambilan contoh uji, pengujian dan monitoring.</li>
            <li>Meningkatkan penerapan praktik yang baik di setiap rantai pasok dan kepatuhan terhadap pemenuhan standar mutu hasil kelautan dan perikanan.</li>
            <li>Mewujudkan sistem jaminan mutu dan keamanan hasil kelautan dan perikanan yang efektif dan selaras dengan standar internasional.</li>
            <li>Meningkatkan tata kelola pemerintahan yang bersih, efektif, dan terpercaya.</li>
          </ul>
        </div>

        {{-- Tujuan --}}
        <div class="about-card">
          <div class="about-h"><i class="fas fa-flag" style="color:var(--gold)"></i> Tujuan</div>
          <div class="about-divider"></div>
          <div style="font-size:14px; color:var(--text); line-height:1.7">
            Mengendalikan dan Mengawasi Mutu dan Keamanan Hasil Kelautan dan Perikanan.
          </div>
        </div>

        {{-- Tugas & Fungsi --}}
        <div class="about-card">
          <div class="about-h"><i class="fas fa-tasks" style="color:var(--gold)"></i> Tugas & Fungsi</div>
          <div class="about-divider"></div>
          <div style="margin-bottom:16px">
            <div style="font-size:12px; font-weight:700; color:var(--gold); text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px">Tugas</div>
            <div style="font-size:13px; color:var(--text); line-height:1.7">
              Menyelenggarakan Pengendalian dan pengawasan mutu dan keamanan hasil kelautan dan perikanan.
            </div>
          </div>
          <div>
            <div style="font-size:12px; font-weight:700; color:var(--gold); text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px">Fungsi</div>
            <ol class="fungsi-list">
              <li>Penyusunan kebijakan teknis, rencana dan program pengendalian dan pengawasan mutu dan keamanan hasil kelautan dan perikanan.</li>
              <li>Pelaksanaan pengendalian dan pengawasan mutu dan keamanan hasil kelautan dan perikanan.</li>
              <li>Pemantauan, evaluasi dan pelaporan pelaksanaan pengendalian dan pengawasan mutu dan keamanan hasil kelautan dan perikanan.</li>
              <li>Pelaksanaan administrasi Badan Pengendalian dan Pengawasan Mutu dan Keamanan Hasil Kelautan dan Perikanan.</li>
              <li>Pelaksanaan fungsi lain yang diberikan oleh Menteri.</li>
            </ol>
          </div>
        </div>

        {{-- Struktur Organisasi --}}
        <div class="about-card">
          <div class="about-h"><i class="fas fa-sitemap" style="color:var(--gold)"></i> Struktur Organisasi</div>
          <div class="about-divider"></div>
          <div class="org-placeholder">
            <i class="fas fa-sitemap" style="font-size:36px; color:rgba(212,175,55,.3); display:block; margin-bottom:10px"></i>
            <div style="font-weight:600; margin-bottom:4px">Bagan Struktur Organisasi</div>
            <div style="font-size:12px">BALAI PPMHKP  Lampung — Kementerian Kelautan dan Perikanan RI</div>
          </div>
        </div>

      </div>

      {{-- RIGHT COLUMN --}}
      <div style="position:sticky; top:90px">

        {{-- Identitas --}}
        <div class="about-card" style="margin-bottom:20px">
          <div class="about-h"><i class="fas fa-id-card" style="color:var(--gold)"></i> Identitas</div>
          <div class="about-divider"></div>
          <table style="width:100%; font-size:13px; border-collapse:collapse">
            <tr>
              <td style="padding:7px 0; color:var(--text-muted); width:40%">Nama Instansi</td>
              <td style="padding:7px 0; font-weight:600; color:var(--text)">Balai PPMHKP Lampung</td>
            </tr>
            <tr>
              <td style="padding:7px 0; color:var(--text-muted); border-top:1px solid var(--border)">Kementerian</td>
              <td style="padding:7px 0; color:var(--text); border-top:1px solid var(--border)">Kelautan dan Perikanan RI</td>
            </tr>
            <tr>
              <td style="padding:7px 0; color:var(--text-muted); border-top:1px solid var(--border)">Telepon</td>
              <td style="padding:7px 0; border-top:1px solid var(--border)">
                <a href="https://api.whatsapp.com/send/?phone=%2B62816245342" target="_blank" style="color:var(--gold); font-weight:600">+62 816-245-342</a>
              </td>
            </tr>
            <tr>
              <td style="padding:7px 0; color:var(--text-muted); border-top:1px solid var(--border)">Website</td>
              <td style="padding:7px 0; border-top:1px solid var(--border)">
                <a href="{{ url('/') }}" style="color:var(--gold)">OneTouch.test</a>
              </td>
            </tr>
          </table>
        </div>

        {{-- Layanan Cepat --}}
        <div class="about-card">
          <div class="about-h"><i class="fas fa-bolt" style="color:var(--gold)"></i> Akses Cepat</div>
          <div class="about-divider"></div>
          <div style="display:flex; flex-direction:column; gap:8px">
            <a href="{{ route('layanan') }}" style="display:flex; align-items:center; gap:8px; padding:9px 12px; background:var(--surface-2); border-radius:8px; text-decoration:none; color:var(--text); font-size:13px; font-weight:500; transition:.2s" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text)'">
              <i class="fas fa-list-check" style="color:var(--gold); width:14px"></i> Layanan Kami
            </a>
            <a href="{{ route('skm') }}" style="display:flex; align-items:center; gap:8px; padding:9px 12px; background:var(--surface-2); border-radius:8px; text-decoration:none; color:var(--text); font-size:13px; font-weight:500; transition:.2s" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text)'">
              <i class="fas fa-star-half-stroke" style="color:var(--gold); width:14px"></i> Data SKM
            </a>
            <a href="{{ route('ekspor') }}" style="display:flex; align-items:center; gap:8px; padding:9px 12px; background:var(--surface-2); border-radius:8px; text-decoration:none; color:var(--text); font-size:13px; font-weight:500; transition:.2s" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text)'">
              <i class="fas fa-ship" style="color:var(--gold); width:14px"></i> Data Ekspor
            </a>
            <a href="{{ route('aplikasi') }}" style="display:flex; align-items:center; gap:8px; padding:9px 12px; background:var(--surface-2); border-radius:8px; text-decoration:none; color:var(--text); font-size:13px; font-weight:500; transition:.2s" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text)'">
              <i class="fas fa-bullhorn" style="color:var(--gold); width:14px"></i> Sampaikan Aspirasi
            </a>
            <a href="{{ route('login') }}" style="display:flex; align-items:center; gap:8px; padding:9px 12px; background:var(--navy); border-radius:8px; text-decoration:none; color:var(--gold); font-size:13px; font-weight:600; transition:.2s">
              <i class="fas fa-right-to-bracket" style="width:14px"></i> Masuk ke Sistem
            </a>
          </div>
        </div>

      </div>
    </div>

    {{-- LOCATION MAP --}}
    <div class="about-card" style="margin-top:8px">
      <div class="about-h"><i class="fas fa-map-location-dot" style="color:var(--gold)"></i> Lokasi Kantor</div>
      <div class="about-divider"></div>
      <div class="map-wrap">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.038181145026!2d105.29224637498406!3d-5.411156094568006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e40db9eb030fbdb%3A0xe50f9cdc317446e3!2sBKIPM%20Lampung!5e0!3m2!1sid!2sid!4v1767596520737!5m2!1sid!2sid"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
      <div style="margin-top:12px; font-size:13px; color:var(--text-muted); display:flex; align-items:center; gap:8px">
        <i class="fas fa-location-dot" style="color:var(--gold)"></i>
        Balai PPMHKP Lampung — Kementerian Kelautan dan Perikanan RI, Bandar Lampung
      </div>
    </div>

  </div>
</section>
@endsection
