@extends('layouts.public')
@section('title', 'Ekspor Hasil Kelautan dan Perikanan')

@push('styles')
<style>
.ekspor-hero {
  background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 50%, #0284c7 100%);
  color: white;
  padding: 40px;
  margin-bottom: 30px;
  border-radius: 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 30px;
  flex-wrap: wrap;
}

.ekspor-hero-title {
  flex: 1;
  min-width: 300px;
}

.ekspor-hero h1 {
  margin: 0 0 10px 0;
  font-size: 28px;
  font-weight: 700;
  text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.ekspor-hero p {
  margin: 0;
  font-size: 18px;
  opacity: 0.95;
}

.ekspor-filters {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  align-items: center;
}

.ekspor-filters input,
.ekspor-filters select {
  padding: 10px 14px;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  background: rgba(255,255,255,0.95);
  color: #0f172a;
}

.ekspor-filters .btn-show {
  background: #fbbf24;
  color: #0f172a;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.ekspor-filters .btn-show:hover {
  background: #f59e0b;
  transform: translateY(-1px);
}

.summary-cards {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-bottom: 30px;
}

.summary-card {
  background: white;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  display: flex;
  align-items: center;
  gap: 16px;
}

.summary-icon {
  width: 56px;
  height: 56px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  flex-shrink: 0;
}

.summary-icon.teal { background: #ccfbf1; color: #0d9488; }
.summary-icon.orange { background: #ffedd5; color: #ea580c; }
.summary-icon.green { background: #dcfce7; color: #16a34a; }
.summary-icon.red { background: #fee2e2; color: #dc2626; }

.summary-info {
  flex: 1;
}

.summary-label {
  font-size: 12px;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 4px;
}

.summary-value {
  font-size: 24px;
  font-weight: 700;
  color: #0f172a;
  line-height: 1.2;
}

.charts-row {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin-bottom: 30px;
}

.chart-card {
  background: white;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.chart-card h3 {
  margin: 0 0 20px 0;
  font-size: 18px;
  color: #0f172a;
  font-weight: 600;
}

.chart-container {
  position: relative;
  height: 300px;
}

.filter-bar {
  background: #f1f5f9;
  padding: 16px 24px;
  border-radius: 12px;
  margin-bottom: 20px;
  display: flex;
  gap: 12px;
  align-items: center;
  flex-wrap: wrap;
}

.filter-bar select {
  padding: 8px 12px;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
  font-size: 14px;
  background: white;
  color: #0f172a;
}

.filter-bar select:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}

.horizontal-chart-card {
  background: white;
  border-radius: 12px;
  padding: 24px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.horizontal-chart-card h3 {
  margin: 0 0 20px 0;
  font-size: 20px;
  color: #0f172a;
  font-weight: 700;
}

.horizontal-chart-container {
  position: relative;
  height: 350px;
}

@media (max-width: 1024px) {
  .summary-cards {
    grid-template-columns: repeat(2, 1fr);
  }
  .charts-row {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .ekspor-hero {
    flex-direction: column;
    text-align: center;
  }
  .ekspor-filters {
    justify-content: center;
  }
  .summary-cards {
    grid-template-columns: 1fr;
  }
}
</style>
@endpush

@section('content')
<!-- HEADER BANNER -->
<div class="ekspor-hero">
  <div class="ekspor-hero-title">
    <h1>EKSPOR HASIL KELAUTAN DAN PERIKANAN BALAI KIPM LAMPUNG</h1>
    <p id="currentPeriod">{{ $summary['year'] }}</p>
  </div>
  <div class="ekspor-filters">
    <input type="date" id="filterStartDate" placeholder="Dari Tanggal">
    <input type="date" id="filterEndDate" placeholder="Sampai Tanggal">
    <select id="filterMonth">
      <option value="">Semua Bulan</option>
      @for($i=1; $i<=12; $i++)
      <option value="{{ $i }}">{{ \App\Models\DataEkspor::getNamaBulan($i) }}</option>
      @endfor
    </select>
    <select id="filterYear">
      <option value="">Semua Tahun</option>
      @foreach($years as $year)
      <option value="{{ $year }}">{{ $year }}</option>
      @endforeach
    </select>
    <button class="btn-show" onclick="applyFilters()">
      <i class="fas fa-filter"></i> Tampilkan
    </button>
  </div>
</div>

<!-- 4 SUMMARY CARDS -->
<div class="summary-cards">
  <div class="summary-card">
    <div class="summary-icon teal">
      <i class="fas fa-bar-chart"></i>
    </div>
    <div class="summary-info">
      <div class="summary-label">Total Frekuensi</div>
      <div class="summary-value" id="totalFrekuensi">{{ number_format($summary['total_frekuensi']) }}</div>
    </div>
  </div>
  <div class="summary-card">
    <div class="summary-icon orange">
      <i class="fas fa-weight-hanging"></i>
    </div>
    <div class="summary-info">
      <div class="summary-label">Total Volume (Ton)</div>
      <div class="summary-value" id="totalVolume">{{ number_format($summary['total_volume'], 3) }}</div>
    </div>
  </div>
  <div class="summary-card">
    <div class="summary-icon green">
      <i class="fas fa-money-bill-wave"></i>
    </div>
    <div class="summary-info">
      <div class="summary-label">Nilai IDR (Juta)</div>
      <div class="summary-value" id="totalNilaiIDR">{{ number_format($summary['total_nilai_idr'] / 1000000, 3) }}</div>
    </div>
  </div>
  <div class="summary-card">
    <div class="summary-icon red">
      <i class="fas fa-dollar-sign"></i>
    </div>
    <div class="summary-info">
      <div class="summary-label">Nilai USD</div>
      <div class="summary-value" id="totalNilaiUSD">{{ number_format($summary['total_nilai_usd'], 2) }}</div>
    </div>
  </div>
</div>

<!-- 2 CHARTS SIDE BY SIDE -->
<div class="charts-row">
  <div class="chart-card">
    <h3>Grafik Frekuensi Ekspor</h3>
    <div class="chart-container">
      <canvas id="lineChart"></canvas>
    </div>
  </div>
  <div class="chart-card">
    <h3>Grafik Volume Ekspor</h3>
    <div class="chart-container">
      <canvas id="barChart"></canvas>
    </div>
  </div>
</div>

<!-- FILTER BAR + HORIZONTAL CHART -->
<div class="filter-bar">
  <select id="categoryFilter" onchange="updateHorizontalChart()">
    <option value="komoditas">Kategori: Komoditas</option>
    <option value="negara_tujuan">Kategori: Negara Tujuan Ekspor</option>
    <option value="unit_pelaksana">Kategori: Unit Pelaksana Teknis</option>
    <option value="eksportir">Kategori: Eksportir</option>
  </select>
  <select id="metricFilter" onchange="updateHorizontalChart()">
    <option value="frekuensi">Berdasarkan: Frekuensi</option>
    <option value="volume">Berdasarkan: Volume</option>
    <option value="nilai">Berdasarkan: Nilai</option>
  </select>
  <select id="limitFilter" onchange="updateHorizontalChart()">
    <option value="5">Limit: TOP 5</option>
    <option value="7">Limit: TOP 7</option>
    <option value="10">Limit: TOP 10</option>
    <option value="all">Limit: Semua</option>
  </select>
</div>

<div class="horizontal-chart-card">
  <h3 id="horizontalChartTitle">GRAFIK TOP 5 KATEGORI KOMODITAS BERDASARKAN FREKUENSI</h3>
  <div class="horizontal-chart-container">
    <canvas id="horizontalChart"></canvas>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const eksporData = @json($eksporData);
let lineChart, barChart, horizontalChart;
let filteredData = [...eksporData];

// Chart Colors
const colors = [
  '#0d9488', '#ea580c', '#16a34a', '#dc2626', '#2563eb',
  '#7c3aed', '#db2777', '#ca8a04', '#0891b2', '#65a30d'
];

// Initialize all charts
document.addEventListener('DOMContentLoaded', function() {
  initLineChart();
  initBarChart();
  initHorizontalChart();
  updateSummary();
});

function applyFilters() {
  const startDate = document.getElementById('filterStartDate').value;
  const endDate = document.getElementById('filterEndDate').value;
  const month = document.getElementById('filterMonth').value;
  const year = document.getElementById('filterYear').value;

  filteredData = eksporData.filter(item => {
    let match = true;
    if (startDate) match = match && new Date(item.tahun, item.bulan - 1) >= new Date(startDate);
    if (endDate) match = match && new Date(item.tahun, item.bulan - 1) <= new Date(endDate);
    if (month) match = match && item.bulan == month;
    if (year) match = match && item.tahun == year;
    return match;
  });

  updateSummary();
  updateLineChart();
  updateBarChart();
  updateHorizontalChart();
}

function updateSummary() {
  const totalFrekuensi = filteredData.reduce((sum, item) => sum + (parseFloat(item.frekuensi) || 0), 0);
  const totalVolume = filteredData.reduce((sum, item) => sum + (parseFloat(item.volume) || 0), 0);
  const totalNilaiUSD = filteredData.reduce((sum, item) => sum + (parseFloat(item.nilai) || 0), 0);
  const totalNilaiIDR = totalNilaiUSD * 15500;

  document.getElementById('totalFrekuensi').textContent = totalFrekuensi.toLocaleString();
  document.getElementById('totalVolume').textContent = totalVolume.toLocaleString(undefined, {minimumFractionDigits: 3, maximumFractionDigits: 3});
  document.getElementById('totalNilaiIDR').textContent = (totalNilaiIDR / 1000000).toLocaleString(undefined, {minimumFractionDigits: 3, maximumFractionDigits: 3});
  document.getElementById('totalNilaiUSD').textContent = totalNilaiUSD.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});

  // Update period text
  const years = [...new Set(filteredData.map(d => d.tahun))].sort();
  document.getElementById('currentPeriod').textContent = years.length > 0 ? years.join(' - ') : 'Data tidak tersedia';
}

function initLineChart() {
  const ctx = document.getElementById('lineChart').getContext('2d');
  const labels = [...new Set(filteredData.map(d => `${d.bulan_nama} ${d.tahun}`))].sort();
  const values = labels.map(label => {
    const [bulan, tahun] = label.split(' ');
    return filteredData.find(d => d.bulan_nama === bulan && d.tahun === parseInt(tahun))?.frekuensi || 0;
  });

  lineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Frekuensi',
        data: values,
        borderColor: '#3b82f6',
        backgroundColor: 'rgba(59, 130, 246, 0.1)',
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#3b82f6',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: { color: 'rgba(0,0,0,0.05)' }
        },
        x: {
          grid: { display: false }
        }
      }
    }
  });
}

function updateLineChart() {
  const labels = [...new Set(filteredData.map(d => `${d.bulan_nama} ${d.tahun}`))].sort();
  const values = labels.map(label => {
    const [bulan, tahun] = label.split(' ');
    return filteredData.find(d => d.bulan_nama === bulan && d.tahun === parseInt(tahun))?.frekuensi || 0;
  });

  lineChart.data.labels = labels;
  lineChart.data.datasets[0].data = values;
  lineChart.update();
}

function initBarChart() {
  const ctx = document.getElementById('barChart').getContext('2d');
  const labels = [...new Set(filteredData.map(d => `${d.bulan_nama} ${d.tahun}`))].sort();
  const values = labels.map(label => {
    const [bulan, tahun] = label.split(' ');
    return filteredData.find(d => d.bulan_nama === bulan && d.tahun === parseInt(tahun))?.volume || 0;
  });

  barChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Volume (Ton)',
        data: values,
        backgroundColor: '#3b82f6',
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: { color: 'rgba(0,0,0,0.05)' }
        },
        x: {
          grid: { display: false }
        }
      }
    }
  });
}

function updateBarChart() {
  const labels = [...new Set(filteredData.map(d => `${d.bulan_nama} ${d.tahun}`))].sort();
  const values = labels.map(label => {
    const [bulan, tahun] = label.split(' ');
    return filteredData.find(d => d.bulan_nama === bulan && d.tahun === parseInt(tahun))?.volume || 0;
  });

  barChart.data.labels = labels;
  barChart.data.datasets[0].data = values;
  barChart.update();
}

function initHorizontalChart() {
  updateHorizontalChart();
}

function updateHorizontalChart() {
  const category = document.getElementById('categoryFilter').value;
  const metric = document.getElementById('metricFilter').value;
  const limit = document.getElementById('limitFilter').value;

  // Group and aggregate data
  const grouped = {};
  filteredData.forEach(item => {
    const key = item[category] || 'Lainnya';
    if (!grouped[key]) grouped[key] = 0;
    grouped[key] += item[metric];
  });

  // Sort and limit
  let sorted = Object.entries(grouped)
    .sort((a, b) => b[1] - a[1]);

  if (limit !== 'all') {
    sorted = sorted.slice(0, parseInt(limit));
  }

  const labels = sorted.map(([name]) => name);
  const values = sorted.map(([, value]) => value);

  // Update chart title
  const categoryNames = {
    'komoditas': 'KOMODITAS',
    'negara_tujuan': 'NEGARA TUJUAN EKSPOR',
    'unit_pelaksana': 'UNIT PELAKSANA TEKNIS',
    'eksportir': 'EKSPORTIR'
  };
  const metricNames = {
    'frekuensi': 'FREKUENSI',
    'volume': 'VOLUME',
    'nilai': 'NILAI'
  };
  const limitText = limit === 'all' ? 'SEMUA' : `TOP ${limit}`;
  document.getElementById('horizontalChartTitle').textContent =
    `GRAFIK ${limitText} KATEGORI ${categoryNames[category]} BERDASARKAN ${metricNames[metric]}`;

  // Create/update chart
  const ctx = document.getElementById('horizontalChart').getContext('2d');
  
  if (horizontalChart) {
    horizontalChart.destroy();
  }

  horizontalChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: metricNames[metric],
        data: values,
        backgroundColor: colors.slice(0, labels.length),
        borderRadius: 6
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        x: {
          beginAtZero: true,
          grid: { color: 'rgba(0,0,0,0.05)' }
        },
        y: {
          grid: { display: false }
        }
      }
    }
  });
}
</script>
@endpush
@endsection