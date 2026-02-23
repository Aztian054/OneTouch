@extends('layouts.internal')
@section('title','Dashboard Officer')
@section('breadcrumb','Dashboard')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded',function(){
  const labels = @json($sertifikatPerJenis->pluck('jenis_sertifikat'));
  const data   = @json($sertifikatPerJenis->pluck('total'));
  new Chart(document.getElementById('jenisChart'),{
    type:'doughnut',
    data:{ labels, datasets:[{ data, backgroundColor:['#0f172a','#1e3a5f','#d4af37','#b8960a','#22c55e','#3b82f6','#f59e0b','#ef4444','#8b5cf6','#06b6d4'] }] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ position:'right' } } }
  });
});
</script>
@endpush

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Dashboard Officer</div>
    <div class="page-subtitle">Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan data lingkup penugasan Anda.</div>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon info"><i class="fas fa-users"></i></div>
    <div><div class="stat-value">{{ $totalUsers }}</div><div class="stat-label">User Ditugaskan</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon navy"><i class="fas fa-certificate"></i></div>
    <div><div class="stat-value">{{ $totalSertifikat }}</div><div class="stat-label">Total Sertifikat</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon success"><i class="fas fa-circle-check"></i></div>
    <div><div class="stat-value">{{ $sertifikatAktif }}</div><div class="stat-label">Sertifikat Aktif</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon warning"><i class="fas fa-triangle-exclamation"></i></div>
    <div><div class="stat-value">{{ $sertifikatWarning }}</div><div class="stat-label">Akan kadaluwarsa dalam ≤ 15 hari</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon danger"><i class="fas fa-circle-xmark"></i></div>
    <div><div class="stat-value">{{ $sertifikatExpired }}</div><div class="stat-label">Kadaluwarsa</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon info"><i class="fas fa-clipboard-check"></i></div>
    <div><div class="stat-value">{{ $totalInspeksi }}</div><div class="stat-label">Total Inspeksi</div></div>
  </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1.4fr; gap:20px; margin-bottom:20px">
  <div class="card">
    <div class="card-header"><span class="card-title">Sertifikat per Jenis</span></div>
    <div class="card-body" style="height:260px; position:relative">
      <canvas id="jenisChart"></canvas>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <span class="card-title">Sertifikat Terbaru</span>
      <a href="{{ route('officer.sertifikat.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
    </div>
    <div class="table-wrap">
      <table class="data-table">
        <thead><tr><th>Nama</th><th>Jenis</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($recentSertifikat as $s)
          <tr>
            <td>{{ $s->nama_pemilik }}</td>
            <td>{{ $s->jenis_sertifikat }}</td>
            <td><span class="badge badge-{{ $s->status_masa }}">{{ $s->status_masa }}</span></td>
          </tr>
          @empty
          <tr><td colspan="3" style="text-align:center; color:var(--text-muted)">Belum ada data</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <span class="card-title">Inspeksi Terbaru</span>
    <a href="{{ route('officer.inspeksi.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
  </div>
  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>Perusahaan</th><th>Tanggal</th><th>Kategori</th><th>Jenis</th><th>Berkas</th></tr></thead>
      <tbody>
        @forelse($recentInspeksi as $ins)
        <tr>
          <td>{{ $ins->nama_perusahaan }}</td>
          <td>{{ $ins->tanggal?->format('d/m/Y') }}</td>
          <td>{{ $ins->kategori }}</td>
          <td>{{ $ins->jenis_sertifikat }}</td>
          <td><span class="badge badge-{{ $ins->status_berkas === 'Terkirim' ? 'terkirim' : 'tidak-ada' }}">{{ $ins->status_berkas }}</span></td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center; color:var(--text-muted)">Belum ada data</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
