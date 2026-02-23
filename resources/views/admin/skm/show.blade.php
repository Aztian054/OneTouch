@extends('layouts.internal')
@section('title','Detail Survey #' . $skmSurvey->id)
@section('breadcrumb','Survey Kepuasan Masyarakat')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
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
        {{ $skmSurvey->q1_kualitas_pelayanan }},
        {{ $skmSurvey->q2_kompetensi_petugas }},
        {{ $skmSurvey->q3_kecepatan }},
        {{ $skmSurvey->q4_kenyamanan }},
        {{ $skmSurvey->q5_kenyamanan_sarpras }},
        {{ $skmSurvey->q6_fasilitas }},
        {{ $skmSurvey->q7_penampilan }}
    ];

    new Chart(document.getElementById('surveyChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rating',
                data: data,
                backgroundColor: [
                    '#0f172a', '#1e3a5f', '#d4af37', '#22c55e', '#3b82f6', '#f59e0b', '#ef4444'
                ],
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
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
    <div class="page-title">Survey #{{ $skmSurvey->id }}</div>
    <div class="page-subtitle">Detail survey dari {{ $skmSurvey->nama }}</div>
  </div>
</div>

<div style="display:grid; grid-template-columns: 2fr 1fr; gap:20px; margin-bottom:20px;">
  <div class="card">
    <div class="card-header"><span class="card-title">Hasil Penilaian</span></div>
    <div class="card-body" style="height:400px; position:relative;">
      <canvas id="surveyChart"></canvas>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><span class="card-title">Info Responden</span></div>
    <div class="card-body">
      <table style="width:100%;">
        <tr>
          <td style="padding:8px 0; color:var(--text-muted);">Nama</td>
          <td style="padding:8px 0; text-align:right; font-weight:600;">{{ $skmSurvey->nama }}</td>
        </tr>
        <tr>
          <td style="padding:8px 0; color:var(--text-muted);">Email</td>
          <td style="padding:8px 0; text-align:right;">{{ $skmSurvey->email ?? '-' }}</td>
        </tr>
        <tr>
          <td style="padding:8px 0; color:var(--text-muted);">No. Telepon</td>
          <td style="padding:8px 0; text-align:right;">{{ $skmSurvey->no_telp ?? '-' }}</td>
        </tr>
        <tr>
          <td style="padding:8px 0; color:var(--text-muted);">Jenis Layanan</td>
          <td style="padding:8px 0; text-align:right;">{{ $skmSurvey->jenis_layanan ?? '-' }}</td>
        </tr>
        <tr>
          <td style="padding:8px 0; color:var(--text-muted);">IP Address</td>
          <td style="padding:8px 0; text-align:right; font-family:monospace; font-size:12px;">{{ $skmSurvey->ip_address ?? '-' }}</td>
        </tr>
        <tr>
          <td style="padding:8px 0; color:var(--text-muted);">Tanggal Submit</td>
          <td style="padding:8px 0; text-align:right;">{{ $skmSurvey->submitted_at?->format('d/m/Y H:i:s') }}</td>
        </tr>
        <tr>
          <td style="padding:8px 0; color:var(--text-muted);">Status</td>
          <td style="padding:8px 0; text-align:right;">
            <span class="badge badge-{{ $skmSurvey->status === 'active' ? 'terkirim' : 'tidak-ada' }}">
              {{ ucfirst($skmSurvey->status) }}
            </span>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:20px;">
  <div class="card">
    <div class="card-header"><span class="card-title">Detail Rating</span></div>
    <div class="card-body">
      @php
      $ratings = [
        'q1_kualitas_pelayanan' => 'Kualitas Pelayanan',
        'q2_kompetensi_petugas' => 'Kompetensi Petugas',
        'q3_kecepatan' => 'Kecepatan',
        'q4_kenyamanan' => 'Kenyamanan',
        'q5_kenyamanan_sarpras' => 'Kenyamanan Sarpras',
        'q6_fasilitas' => 'Fasilitas',
        'q7_penampilan' => 'Penampilan',
      ];
      @endphp
      @foreach($ratings as $key => $label)
      <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 0; border-bottom:1px solid #f3f4f6;">
        <span>{{ $label }}</span>
        <div style="display:flex; align-items:center; gap:8px;">
          <div style="width:150px; height:8px; background:#e5e7eb; border-radius:4px; overflow:hidden;">
            <div style="width:{{ ($skmSurvey->$key / 5) * 100 }}%; height:100%; background:#0f172a;"></div>
          </div>
          <strong style="min-width:40px; text-align:right;">{{ number_format($skmSurvey->$key, 1) }}</strong>
        </div>
      </div>
      @endforeach
      <div style="display:flex; align-items:center; justify-content:space-between; padding:15px 0; background:#f9fafb; margin-top:10px; padding:15px; border-radius:6px;">
        <span style="font-weight:600; font-size:16px;">Rata-rata Total</span>
        <div style="display:flex; align-items:center; gap:8px;">
          <i class="fas fa-star" style="color:#d4af37; font-size:20px;"></i>
          <strong style="font-size:18px; color:#d4af37;">{{ number_format($skmSurvey->average_rating, 1) }}/5</strong>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><span class="card-title">Saran & Masukan</span></div>
    <div class="card-body">
      @if($skmSurvey->saran_masukan)
      <div style="background:#f9fafb; padding:20px; border-radius:8px; border-left:4px solid #d4af37; font-style:italic; line-height:1.6;">
        "{{ $skmSurvey->saran_masukan }}"
      </div>
      @else
      <div style="color:var(--text-muted); text-align:center; padding:40px;">Tidak ada saran atau masukan</div>
      @endif
    </div>
  </div>
</div>

<div style="display:flex; gap:10px;">
  <a href="{{ route('admin.skm.index') }}" class="btn btn-outline">
    <i class="fas fa-arrow-left" style="margin-right:5px;"></i> Kembali
  </a>
  <a href="{{ route('admin.skm.edit', $skmSurvey) }}" class="btn btn-warning">
    <i class="fas fa-edit" style="margin-right:5px;"></i> Edit Survey
  </a>
  <a href="{{ route('admin.skm.export.pdf', request()->all()) }}" class="btn btn-outline">
    <i class="fas fa-file-pdf" style="margin-right:5px;"></i> Export PDF
  </a>
  <form action="{{ route('admin.skm.destroy', $skmSurvey) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus survey ini?')">
      <i class="fas fa-trash" style="margin-right:5px;"></i> Hapus
    </button>
  </form>
</div>
@endsection