@extends('layouts.public')
@section('title', 'SKM')
@push('styles')
<style>
.page-hero { background:var(--navy); padding:56px 0 48px; text-align:center; position:relative; overflow:hidden; }
.page-hero::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(15,23,42,.95),rgba(30,58,95,.8)); }
.page-hero-content { position:relative; z-index:1; }
.page-hero h1 { font-size:clamp(24px,4vw,40px); font-weight:800; color:#fff; margin-bottom:8px; }
.page-hero p { font-size:15px; color:rgba(255,255,255,.6); max-width:520px; margin:0 auto; }
.page-badge { display:inline-flex; align-items:center; gap:6px; background:rgba(212,175,55,.15); border:1px solid rgba(212,175,55,.3); color:var(--gold); padding:5px 14px; border-radius:20px; font-size:11px; font-weight:600; margin-bottom:14px; }

.skm-summary { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:16px; margin-bottom:32px; }
.skm-stat { background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:20px; text-align:center; }
.skm-stat-value { font-size:28px; font-weight:800; color:var(--navy); }
html.dark .skm-stat-value { color:var(--gold); }
.skm-stat-label { font-size:12px; color:var(--text-muted); margin-top:4px; }
.skm-stat-year { font-size:11px; color:var(--gold); font-weight:600; margin-top:2px; }

.survey-form-section { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:32px; margin-top:32px; box-shadow:0 4px 20px rgba(15,23,42,.08); }
.survey-section-title { font-size:20px; font-weight:700; color:var(--text); margin-bottom:20px; display:flex; align-items:center; gap:8px; }
.survey-section-title i { color:var(--gold); }

.form-group { margin-bottom:20px; }
.form-label { display:block; margin-bottom:8px; font-weight:600; color:var(--text); font-size:14px; }
.form-control { width:100%; padding:12px 16px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px; transition:all 0.3s; background:var(--surface); color:var(--text); }
.form-control:focus { outline:none; border-color:var(--gold); box-shadow:0 0 0 3px rgba(212,175,55,.1); }
html.dark .form-control { border-color:#374151; background:#1e293b; }
html.dark .form-control:focus { border-color:var(--gold); }

.rating-group { display:flex; align-items:center; gap:12px; margin-bottom:16px; }
.rating-stars { display:flex; gap:4px; }
.rating-star { font-size:28px; cursor:pointer; color:#d1d5db; transition:all 0.2s; }
.rating-star:hover { transform:scale(1.15); }
.rating-star.active { color:#d4af37; }
.rating-value { font-size:20px; font-weight:700; color:var(--navy); min-width:50px; }
html.dark .rating-value { color:var(--gold); }

.rating-labels { display:flex; justify-content:space-between; font-size:12px; color:var(--text-muted); margin-top:4px; padding:0 4px; }

.survey-actions { display:flex; gap:12px; margin-top:24px; }
.survey-privacy { font-size:13px; color:var(--text-muted); display:flex; align-items:center; gap:6px; margin-top:16px; }
.survey-privacy i { color:var(--gold); }

.success-message { background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.3); color:#22c55e; padding:20px; border-radius:12px; text-align:center; margin-bottom:24px; }
.success-message i { font-size:48px; margin-bottom:12px; display:block; }
</style>
@endpush

@section('content')
<div class="page-hero">
  <div class="container page-hero-content">
    <div class="page-badge"><i class="fas fa-star-half-stroke"></i> Kepuasan Masyarakat</div>
    <h1>Hasil Survey Kepuasan Masyarakat</h1>
    <p>Indeks Kepuasan Masyarakat (IKM) BALAI PPMHKP Lampung — capaian target layanan per tahun</p>
  </div>
</div>

<section class="section">
  <div class="container">

    {{-- Survey Stats Summary --}}
    <div class="skm-summary">
      <div class="skm-stat">
        <div class="skm-stat-value">{{ $totalSurveys }}</div>
        <div class="skm-stat-label">Total Survey</div>
        <div class="skm-stat-year">6 bulan terakhir</div>
      </div>
      <div class="skm-stat">
        <div class="skm-stat-value">{{ number_format($avgOverall, 2) }}</div>
        <div class="skm-stat-label">Rata-rata Rating</div>
        <div class="skm-stat-year">Semua Survey</div>
      </div>
      @if($skmData->count())
      @foreach($skmData as $skm)
      <div class="skm-stat">
        <div class="skm-stat-value">{{ number_format($skm->realisasi, 2) }}</div>
        <div class="skm-stat-label">Realisasi IKM</div>
        <div class="skm-stat-year">Tahun {{ $skm->tahun }}</div>
      </div>
      @endforeach
      @endif
    </div>

    {{-- Chart --}}
    <div class="card">
      <div class="card-header" style="background:var(--surface); border-bottom:1px solid var(--border); padding:20px 24px;">
        <div style="font-size:16px; font-weight:700; color:var(--text)">
          <i class="fas fa-chart-bar" style="color:var(--gold); margin-right:8px"></i>
          Grafik SKM Per Tahun — Target vs Realisasi
        </div>
      </div>
      <div style="padding:28px; background:var(--surface)">
        <canvas id="skmChart" height="100"></canvas>
      </div>
    </div>

    {{-- Real-time Survey Charts --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(400px, 1fr)); gap:20px; margin-top:24px;">
      <div class="card">
        <div class="card-header" style="background:var(--surface); border-bottom:1px solid var(--border); padding:20px 24px;">
          <div style="font-size:16px; font-weight:700; color:var(--text)">
            <i class="fas fa-chart-line" style="color:var(--gold); margin-right:8px"></i>
            Trend Survey (6 Bulan Terakhir)
          </div>
        </div>
        <div style="padding:28px; background:var(--surface)">
          <canvas id="surveyTrendChart" height="120"></canvas>
        </div>
      </div>

      <div class="card">
        <div class="card-header" style="background:var(--surface); border-bottom:1px solid var(--border); padding:20px 24px;">
          <div style="font-size:16px; font-weight:700; color:var(--text)">
            <i class="fas fa-chart-pie" style="color:var(--gold); margin-right:8px"></i>
            Distribusi Rating Survey
          </div>
        </div>
        <div style="padding:28px; background:var(--surface)">
          <canvas id="ratingDistChart" height="120"></canvas>
        </div>
      </div>
    </div>

    {{-- Survey Form Section --}}
    <div class="survey-form-section">
      @if(session('success'))
      <div class="success-message">
        <i class="fas fa-check-circle"></i>
        <h3 style="margin:0 0 8px; color:var(--text);">Terima Kasih!</h3>
        <p style="margin:0; color:var(--text-muted);">Survey Anda telah berhasil dikirim. Masukan Anda sangat berharga bagi kami.</p>
      </div>
      @endif

      <div class="survey-section-title">
        <i class="fas fa-clipboard-list"></i>
        Isi Survey Kepuasan Masyarakat
      </div>
      <p style="color:var(--text-muted); margin-bottom:24px;">Bantu kami meningkatkan kualitas layanan dengan mengisi survey ini. Waktu pengisian: ±2 menit</p>

      <form method="POST" action="{{ route('skm.submit') }}">
        @csrf

        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:20px; margin-bottom:24px;">
          <div class="form-group">
            <label class="form-label">Nama Lengkap <span style="color:#ef4444;">*</span></label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
          </div>
          <div class="form-group">
            <label class="form-label">Email (Opsional)</label>
            <input type="email" name="email" class="form-control" placeholder="email@contoh.com">
          </div>
          <div class="form-group">
            <label class="form-label">Nomor Telepon (Opsional)</label>
            <input type="text" name="no_telp" class="form-control" placeholder="08xxxxxxxxxx">
          </div>
          <div class="form-group">
            <label class="form-label">Jenis Layanan yang Digunakan <span style="color:#ef4444;">*</span></label>
            <select name="jenis_layanan" class="form-control" required>
              <option value="">-- Pilih Jenis Layanan --</option>
              <option value="Sertifikasi Karantina">Sertifikasi Karantina</option>
              <option value="Sertifikasi Mutu">Sertifikasi Mutu</option>
              <option value="Inspeksi Higiene">Inspeksi Higiene</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
        </div>

        <div class="survey-section-title" style="margin-top:32px;">
          <i class="fas fa-star"></i>
          Penilaian Layanan (1-5)
        </div>

        <div style="background:var(--surface-2); padding:24px; border-radius:12px; margin-bottom:20px;">
          @php
          $questions = [
            ['key' => 'q1_kualitas_pelayanan', 'label' => 'Bagaimana kualitas pelayanan yang Anda terima?'],
            ['key' => 'q2_kompetensi_petugas', 'label' => 'Bagaimana kompetensi petugas yang melayani?'],
            ['key' => 'q3_kecepatan', 'label' => 'Bagaimana kecepatan layanan kami?'],
            ['key' => 'q4_kenyamanan', 'label' => 'Bagaimana kenyamanan saat menerima layanan?'],
            ['key' => 'q5_kenyamanan_sarpras', 'label' => 'Bagaimana kenyamanan sarana prasarana?'],
            ['key' => 'q6_fasilitas', 'label' => 'Bagaimana fasilitas yang tersedia?'],
            ['key' => 'q7_penampilan', 'label' => 'Bagaimana penampilan petugas?'],
          ];
          @endphp
          @foreach($questions as $index => $question)
          <div style="{{ $index < count($questions) - 1 ? 'margin-bottom:24px; padding-bottom:24px; border-bottom:1px solid var(--border);' : '' }}">
            <label class="form-label">{{ $question['label'] }} <span style="color:#ef4444;">*</span></label>
            <div class="rating-group" data-question="{{ $question['key'] }}">
              <input type="hidden" name="{{ $question['key'] }}" class="rating-input" value="0" required>
              <div class="rating-stars">
                @for($i = 1; $i <= 5; $i++)
                <span class="rating-star" data-value="{{ $i }}">⭐</span>
                @endfor
              </div>
              <span class="rating-value">0</span>
            </div>
            <div class="rating-labels">
              <span>Sangat Buruk</span>
              <span>Sangat Bagus</span>
            </div>
          </div>
          @endforeach
        </div>

        <div class="form-group">
          <label class="form-label">Saran & Masukan (Opsional)</label>
          <textarea name="saran_masukan" class="form-control" rows="4" placeholder="Tuliskan saran atau masukan Anda di sini..."></textarea>
        </div>

        <div class="survey-privacy">
          <i class="fas fa-shield-alt"></i>
          Data Anda dirahasiakan dan tidak akan dipublikasikan
        </div>

        <div class="survey-actions">
          <button type="reset" class="btn btn-outline">Reset</button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane" style="margin-right:8px;"></i>
            Kirim Survey
          </button>
        </div>
      </form>
    </div>

    {{-- Data Table --}}
    @if($skmData->count())
    <div class="card" style="margin-top:24px">
      <div class="card-header" style="background:var(--surface); border-bottom:1px solid var(--border); padding:16px 24px;">
        <div style="font-size:15px; font-weight:700; color:var(--text)"><i class="fas fa-table" style="color:var(--gold); margin-right:8px"></i> Tabel Data SKM</div>
      </div>
      <div style="background:var(--surface)">
        <table style="width:100%; border-collapse:collapse; font-size:14px;">
          <thead>
            <tr style="background:var(--surface-2)">
              <th style="padding:12px 20px; text-align:left; font-weight:600; color:var(--text-muted); font-size:12px; text-transform:uppercase; border-bottom:1px solid var(--border)">Tahun</th>
              <th style="padding:12px 20px; text-align:center; font-weight:600; color:var(--text-muted); font-size:12px; text-transform:uppercase; border-bottom:1px solid var(--border)">Target</th>
              <th style="padding:12px 20px; text-align:center; font-weight:600; color:var(--text-muted); font-size:12px; text-transform:uppercase; border-bottom:1px solid var(--border)">Realisasi</th>
              <th style="padding:12px 20px; text-align:center; font-weight:600; color:var(--text-muted); font-size:12px; text-transform:uppercase; border-bottom:1px solid var(--border)">Capaian</th>
            </tr>
          </thead>
          <tbody>
            @foreach($skmData as $skm)
            @php $pct = $skm->target > 0 ? round($skm->realisasi / $skm->target * 100, 1) : 0; @endphp
            <tr style="border-bottom:1px solid var(--border)">
              <td style="padding:14px 20px; font-weight:600; color:var(--text)">{{ $skm->tahun }}</td>
              <td style="padding:14px 20px; text-align:center; color:var(--text-muted)">{{ number_format($skm->target, 2) }}</td>
              <td style="padding:14px 20px; text-align:center; font-weight:700; color:var(--navy)">
                <span style="color:{{ $skm->realisasi >= $skm->target ? '#22c55e' : '#ef4444' }}">
                  {{ number_format($skm->realisasi, 2) }}
                </span>
              </td>
              <td style="padding:14px 20px; text-align:center">
                <span style="
                  display:inline-block; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600;
                  background:{{ $pct >= 100 ? 'rgba(34,197,94,.1)' : 'rgba(239,68,68,.1)' }};
                  color:{{ $pct >= 100 ? '#22c55e' : '#ef4444' }}
                ">{{ $pct }}%</span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @else
    <div style="text-align:center; padding:60px 20px; color:var(--text-muted)">
      <i class="fas fa-chart-bar" style="font-size:48px; opacity:.2; margin-bottom:12px; display:block"></i>
      Belum ada data SKM tersedia.
    </div>
    @endif
  </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Rating Stars Functionality
document.addEventListener('DOMContentLoaded', function(){
  // Chart.js for SKM Data
  (function(){
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255,255,255,.08)' : 'rgba(0,0,0,.06)';
    const textColor = isDark ? 'rgba(255,255,255,.6)' : 'rgba(15,23,42,.6)';

    const labels = @json($skmData->pluck('tahun'));
    const targets = @json($skmData->pluck('target'));
    const realisasi = @json($skmData->pluck('realisasi'));

    new Chart(document.getElementById('skmChart'), {
      type: 'bar',
      data: {
        labels,
        datasets: [
          {
            label: 'Target IKM',
            data: targets,
            backgroundColor: 'rgba(15,23,42,.7)',
            borderRadius: 6,
          },
          {
            label: 'Realisasi IKM',
            data: realisasi,
            backgroundColor: 'rgba(212,175,55,.85)',
            borderRadius: 6,
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { labels: { color: textColor, font: { family: 'Inter' } } },
          tooltip: { callbacks: { label: ctx => ' ' + ctx.dataset.label + ': ' + ctx.parsed.y.toFixed(2) } }
        },
        scales: {
          x: { grid: { color: gridColor }, ticks: { color: textColor } },
          y: {
            grid: { color: gridColor }, ticks: { color: textColor },
            min: 0, max: 5,
            title: { display: true, text: 'Nilai IKM (skala 1–5)', color: textColor }
          }
        }
      }
    });
  })();

  // Survey Trend Chart (Line chart)
  (function(){
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255,255,255,.08)' : 'rgba(0,0,0,.06)';
    const textColor = isDark ? 'rgba(255,255,255,.6)' : 'rgba(15,23,42,.6)';
    
    const labels = @json($surveyStats->pluck('month'));
    const counts = @json($surveyStats->pluck('total_surveys'));
    const ratings = @json($surveyStats->pluck('avg_rating'));

    new Chart(document.getElementById('surveyTrendChart'), {
      type: 'line',
      data: {
        labels,
        datasets: [
          {
            label: 'Total Survey',
            data: counts,
            borderColor: 'rgba(15,23,42,1)',
            backgroundColor: 'rgba(15,23,42,.1)',
            fill: true,
            tension: 0.4,
            yAxisID: 'y'
          },
          {
            label: 'Rata-rata Rating',
            data: ratings,
            borderColor: 'rgba(212,175,55,1)',
            backgroundColor: 'rgba(212,175,55,.1)',
            fill: true,
            tension: 0.4,
            yAxisID: 'y1'
          }
        ]
      },
      options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: {
          legend: { labels: { color: textColor, font: { family: 'Inter' } } }
        },
        scales: {
          x: { grid: { color: gridColor }, ticks: { color: textColor } },
          y: {
            type: 'linear',
            display: true,
            position: 'left',
            grid: { color: gridColor },
            ticks: { color: textColor },
            title: { display: true, text: 'Jumlah Survey', color: textColor }
          },
          y1: {
            type: 'linear',
            display: true,
            position: 'right',
            grid: { drawOnChartArea: false },
            ticks: { color: textColor },
            min: 0, max: 5,
            title: { display: true, text: 'Rating', color: textColor }
          }
        }
      }
    });
  })();

  // Rating Distribution Chart (Pie chart)
  (function(){
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? 'rgba(255,255,255,.6)' : 'rgba(15,23,42,.6)';
    
    const labels = @json($ratingDistribution->pluck('avg_rating')->map(function($r) { return 'Rating ' . $r; }));
    const counts = @json($ratingDistribution->pluck('count'));
    
    const colors = [
      'rgba(239,68,68,0.8)',   // 1 - Red
      'rgba(245,158,11,0.8)',  // 2 - Orange
      'rgba(251,191,36,0.8)',  // 3 - Yellow
      'rgba(34,197,94,0.8)',    // 4 - Green
      'rgba(15,23,42,0.8)'     // 5 - Navy
    ];

    new Chart(document.getElementById('ratingDistChart'), {
      type: 'doughnut',
      data: {
        labels,
        datasets: [{
          data: counts,
          backgroundColor: colors,
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { 
            position: 'bottom',
            labels: { color: textColor, font: { family: 'Inter' } }
          }
        }
      }
    });
  })();

  // Rating Stars Interaction
  document.querySelectorAll('.rating-group').forEach(group => {
    const stars = group.querySelectorAll('.rating-star');
    const input = group.querySelector('.rating-input');
    const valueDisplay = group.querySelector('.rating-value');

    stars.forEach((star, index) => {
      star.addEventListener('click', () => {
        const value = star.dataset.value;
        input.value = value;
        valueDisplay.textContent = value;
        
        stars.forEach((s, i) => {
          s.classList.toggle('active', i < value);
        });
      });

      star.addEventListener('mouseenter', () => {
        stars.forEach((s, i) => {
          s.style.color = i <= index ? '#d4af37' : '#d1d5db';
        });
      });
    });

    group.addEventListener('mouseleave', () => {
      const value = input.value;
      stars.forEach((s, i) => {
        s.style.color = i < value ? '#d4af37' : '#d1d5db';
      });
    });
  });
});
</script>
@endpush