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
</style>
@endpush

@section('content')
<div class="page-hero">
  <div class="container page-hero-content">
    <div class="page-badge"><i class="fas fa-star-half-stroke"></i> Kepuasan Masyarakat</div>
    <h1>Hasil Survey Kepuasan Masyarakat</h1>
    <p>Indeks Kepuasan Masyarakat (IKM) BPPMHKP Lampung — capaian target layanan per tahun</p>
  </div>
</div>

<section class="section">
  <div class="container">

    {{-- Summary Stats --}}
    @if($skmData->count())
    <div class="skm-summary">
      @foreach($skmData as $skm)
      <div class="skm-stat">
        <div class="skm-stat-value">{{ number_format($skm->realisasi, 2) }}</div>
        <div class="skm-stat-label">Realisasi IKM</div>
        <div class="skm-stat-year">Tahun {{ $skm->tahun }}</div>
      </div>
      @endforeach
    </div>
    @endif

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
</script>
@endpush
