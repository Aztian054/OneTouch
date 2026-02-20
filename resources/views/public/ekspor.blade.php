@extends('layouts.public')
@section('title', 'Data Ekspor')
@push('styles')
<style>
.page-hero { background:var(--navy); padding:56px 0 48px; text-align:center; position:relative; overflow:hidden; }
.page-hero::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(15,23,42,.95),rgba(30,58,95,.8)); }
.page-hero-content { position:relative; z-index:1; }
.page-hero h1 { font-size:clamp(24px,4vw,40px); font-weight:800; color:#fff; margin-bottom:8px; }
.page-hero p { font-size:15px; color:rgba(255,255,255,.6); max-width:520px; margin:0 auto; }
.page-badge { display:inline-flex; align-items:center; gap:6px; background:rgba(212,175,55,.15); border:1px solid rgba(212,175,55,.3); color:var(--gold); padding:5px 14px; border-radius:20px; font-size:11px; font-weight:600; margin-bottom:14px; }
.chart-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
.chart-card-header { padding:18px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
.chart-card-title { font-size:15px; font-weight:700; color:var(--text); }
.chart-card-body { padding:24px; }
.year-filter { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:28px; }
.year-btn { padding:6px 16px; border:1px solid var(--border); border-radius:20px; background:var(--surface); color:var(--text-muted); font-size:13px; cursor:pointer; transition:.2s; }
.year-btn.active { background:var(--navy); color:var(--gold); border-color:var(--navy); }
</style>
@endpush

@section('content')
<div class="page-hero">
  <div class="container page-hero-content">
    <div class="page-badge"><i class="fas fa-ship"></i> Data Ekspor</div>
    <h1>Data Ekspor BPPMHKP Lampung</h1>
    <p>Grafik realisasi ekspor hasil perikanan bulanan — frekuensi, volume, dan nilai ekspor</p>
  </div>
</div>

<section class="section">
  <div class="container">

    {{-- Year filter --}}
    @if($years->count())
    <div class="year-filter" id="yearFilter">
      @foreach($years as $y)
      <button class="year-btn {{ $loop->last ? 'active' : '' }}" onclick="setYear({{ $y }}, this)">{{ $y }}</button>
      @endforeach
    </div>
    @endif

    <div style="display:grid; grid-template-columns:1fr; gap:24px">

      {{-- Frekuensi --}}
      <div class="chart-card">
        <div class="chart-card-header">
          <i class="fas fa-hashtag" style="color:var(--gold)"></i>
          <div class="chart-card-title">Frekuensi Ekspor (kali/bulan)</div>
        </div>
        <div class="chart-card-body"><canvas id="chartFrekuensi" height="80"></canvas></div>
      </div>

      {{-- Volume --}}
      <div class="chart-card">
        <div class="chart-card-header">
          <i class="fas fa-weight-hanging" style="color:var(--gold)"></i>
          <div class="chart-card-title">Volume Ekspor (ton)</div>
        </div>
        <div class="chart-card-body"><canvas id="chartVolume" height="80"></canvas></div>
      </div>

      {{-- Nilai --}}
      <div class="chart-card">
        <div class="chart-card-header">
          <i class="fas fa-dollar-sign" style="color:var(--gold)"></i>
          <div class="chart-card-title">Nilai Ekspor (USD)</div>
        </div>
        <div class="chart-card-body"><canvas id="chartNilai" height="80"></canvas></div>
      </div>

    </div>
  </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const eksporAll = @json($eksporData);
const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

const isDark = document.documentElement.classList.contains('dark');
const gridColor = isDark ? 'rgba(255,255,255,.08)' : 'rgba(0,0,0,.06)';
const textColor = isDark ? 'rgba(255,255,255,.6)' : 'rgba(15,23,42,.6)';

function makeChart(id, label, color, data) {
  return new Chart(document.getElementById(id), {
    type: 'line',
    data: {
      labels: months,
      datasets: [{
        label,
        data,
        borderColor: color,
        backgroundColor: color.replace(')', ',.1)').replace('rgb', 'rgba'),
        fill: true,
        tension: .4,
        pointBackgroundColor: color,
        pointRadius: 5,
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { labels: { color: textColor, font: { family: 'Inter' } } } },
      scales: {
        x: { grid: { color: gridColor }, ticks: { color: textColor } },
        y: { grid: { color: gridColor }, ticks: { color: textColor }, beginAtZero: true }
      }
    }
  });
}

let charts = {};

function initCharts(year) {
  const rows = eksporAll.filter(r => r.tahun == year);
  const frek = Array(12).fill(0); const vol = Array(12).fill(0); const nil = Array(12).fill(0);
  rows.forEach(r => { const m = r.bulan - 1; frek[m] = r.frekuensi; vol[m] = r.volume; nil[m] = r.nilai; });

  if(charts.f){ charts.f.destroy(); charts.v.destroy(); charts.n.destroy(); }
  charts.f = makeChart('chartFrekuensi', 'Frekuensi (kali)', 'rgb(212,175,55)', frek);
  charts.v = makeChart('chartVolume', 'Volume (ton)', 'rgb(59,130,246)', vol);
  charts.n = makeChart('chartNilai', 'Nilai (USD)', 'rgb(34,197,94)', nil);
}

window.setYear = function(year, btn) {
  document.querySelectorAll('.year-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  initCharts(year);
};

const years = @json($years);
if(years.length) initCharts(years[years.length - 1]);
</script>
@endpush
