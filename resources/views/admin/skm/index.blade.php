@extends('layouts.internal')
@section('title','Survey Kepuasan Masyarakat')
@section('breadcrumb','Survey Kepuasan Masyarakat')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const chartData = @json($chartData);
    const labels = [
        'Kualitas Pelayanan',
        'Kompetensi Petugas',
        'Kecepatan',
        'Kenyamanan',
        'Kenyamanan Sarpras',
        'Fasilitas',
        'Penampilan'
    ];
    const data = [
        chartData.q1_kualitas_pelayanan,
        chartData.q2_kompetensi_petugas,
        chartData.q3_kecepatan,
        chartData.q4_kenyamanan,
        chartData.q5_kenyamanan_sarpras,
        chartData.q6_fasilitas,
        chartData.q7_penampilan
    ];

    new Chart(document.getElementById('skmChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rata-rata Rating (1-5)',
                data: data,
                backgroundColor: '#0f172a',
                borderRadius: 6,
                borderSkipped: false,
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
                    max: 5,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
});
</script>
@endpush

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Survey Kepuasan Masyarakat</div>
    <div class="page-subtitle">Kelola dan pantau hasil survey kepuasan masyarakat</div>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon navy"><i class="fas fa-clipboard-list"></i></div>
    <div><div class="stat-value">{{ $stats['total'] }}</div><div class="stat-label">Total Survey</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon success"><i class="fas fa-calendar-day"></i></div>
    <div><div class="stat-value">{{ $stats['today'] }}</div><div class="stat-label">Hari Ini</div></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon gold"><i class="fas fa-star"></i></div>
    <div><div class="stat-value">{{ $stats['average_rating'] ?? 0 }}</div><div class="stat-label">Rata-rata Rating</div></div>
  </div>
</div>

<div style="display:grid; grid-template-columns: 2fr 1fr; gap:20px; margin-bottom:20px;">
  <div class="card">
    <div class="card-body" style="height:320px; position:relative;">
      <canvas id="skmChart"></canvas>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <span class="card-title">Filter Data</span>
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('admin.skm.index') }}">
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:600;">Cari</label>
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email..." class="form-control" style="width:100%; padding:8px 12px; border:1px solid #e5e7eb; border-radius:6px;">
        </div>
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:600;">Status</label>
          <select name="status" class="form-control" style="width:100%; padding:8px 12px; border:1px solid #e5e7eb; border-radius:6px;">
            <option value="">Semua</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
          </select>
        </div>
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:600;">Jenis Layanan</label>
          <select name="jenis_layanan" class="form-control" style="width:100%; padding:8px 12px; border:1px solid #e5e7eb; border-radius:6px;">
            <option value="">Semua</option>
            <option value="Sertifikasi Karantina" {{ request('jenis_layanan') === 'Sertifikasi Karantina' ? 'selected' : '' }}>Sertifikasi Karantina</option>
            <option value="Sertifikasi Mutu" {{ request('jenis_layanan') === 'Sertifikasi Mutu' ? 'selected' : '' }}>Sertifikasi Mutu</option>
            <option value="Inspeksi Higiene" {{ request('jenis_layanan') === 'Inspeksi Higiene' ? 'selected' : '' }}>Inspeksi Higiene</option>
            <option value="Lainnya" {{ request('jenis_layanan') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
          </select>
        </div>
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:600;">Dari Tanggal</label>
          <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control" style="width:100%; padding:8px 12px; border:1px solid #e5e7eb; border-radius:6px;">
        </div>
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:600;">Sampai Tanggal</label>
          <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control" style="width:100%; padding:8px 12px; border:1px solid #e5e7eb; border-radius:6px;">
        </div>
        <div style="display:flex; gap:10px;">
          <button type="submit" class="btn btn-primary" style="flex:1;">Filter</button>
          <a href="{{ route('admin.skm.index') }}" class="btn btn-outline" style="flex:1; text-align:center;">Reset</a>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <span class="card-title">Daftar Survey</span>
    <div style="display:flex; gap:10px;">
      <a href="{{ route('admin.skm.export.excel', request()->all()) }}" class="btn btn-outline btn-sm">
        <i class="fas fa-file-excel" style="margin-right:5px;"></i> Export Excel
      </a>
      <a href="{{ route('admin.skm.export.pdf', request()->all()) }}" class="btn btn-outline btn-sm">
        <i class="fas fa-file-pdf" style="margin-right:5px;"></i> Export PDF
      </a>
    </div>
  </div>
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Jenis Layanan</th>
          <th>Rating</th>
          <th>Status</th>
          <th>Tanggal</th>
          <th style="text-align:right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($surveys as $survey)
        <tr>
          <td>{{ $survey->id }}</td>
          <td>
            <div style="font-weight:600;">{{ $survey->nama }}</div>
            @if($survey->email)
            <div style="font-size:12px; color:var(--text-muted);">{{ $survey->email }}</div>
            @endif
          </td>
          <td>{{ $survey->jenis_layanan ?? '-' }}</td>
          <td>
            <div style="display:flex; align-items:center; gap:5px;">
              <i class="fas fa-star" style="color:#d4af37;"></i>
              <strong>{{ number_format($survey->average_rating, 1) }}/5</strong>
            </div>
          </td>
          <td>
            <span class="badge badge-{{ $survey->status === 'active' ? 'terkirim' : 'tidak-ada' }}">
              {{ ucfirst($survey->status) }}
            </span>
          </td>
          <td>{{ $survey->submitted_at?->format('d/m/Y H:i') }}</td>
          <td style="text-align:right;">
            <div style="display:flex; gap:5px; justify-content:flex-end;">
              <a href="{{ route('admin.skm.show', $survey) }}" class="btn-icon btn-info" title="Detail">
                <i class="fas fa-eye"></i>
              </a>
              <a href="{{ route('admin.skm.edit', $survey) }}" class="btn-icon btn-warning" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              <form action="{{ route('admin.skm.destroy', $survey) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-icon btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus survey ini?')">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center; color:var(--text-muted); padding:40px;">Belum ada data survey</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="padding:15px; display:flex; justify-content:space-between; align-items:center;">
    <div style="color:var(--text-muted); font-size:14px;">Menampilkan {{ $surveys->firstItem() ?? 0 }}-{{ $surveys->lastItem() ?? 0 }} dari {{ $surveys->total() }} data</div>
    {{ $surveys->links() }}
  </div>
</div>
@endsection