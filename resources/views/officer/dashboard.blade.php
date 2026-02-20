@extends('layouts.internal')
@section('title','Dashboard Officer')
@section('breadcrumb','Dashboard')
@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Selamat Datang, {{ auth()->user()->name }}</div>
    <div class="page-subtitle">Officer Dashboard — Data lingkup penugasan Anda</div>
  </div>
</div>

{{-- Stats --}}
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon" style="background:rgba(15,23,42,.08)"><i class="fas fa-users" style="color:var(--navy)"></i></div>
    <div class="stat-body">
      <div class="stat-value">{{ $totalUsers }}</div>
      <div class="stat-label">User Ditugaskan</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:rgba(212,175,55,.12)"><i class="fas fa-certificate" style="color:var(--gold)"></i></div>
    <div class="stat-body">
      <div class="stat-value">{{ $totalSertifikat }}</div>
      <div class="stat-label">Total Sertifikat</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:rgba(34,197,94,.12)"><i class="fas fa-check-circle" style="color:#22c55e"></i></div>
    <div class="stat-body">
      <div class="stat-value">{{ $sertifikatAktif }}</div>
      <div class="stat-label">Sertifikat Aktif</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:rgba(239,68,68,.12)"><i class="fas fa-times-circle" style="color:#ef4444"></i></div>
    <div class="stat-body">
      <div class="stat-value">{{ $sertifikatExpired }}</div>
      <div class="stat-label">Sertifikat Expired</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:rgba(234,179,8,.12)"><i class="fas fa-exclamation-triangle" style="color:#eab308"></i></div>
    <div class="stat-body">
      <div class="stat-value">{{ $sertifikatWarning }}</div>
      <div class="stat-label">Akan Expired</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:rgba(99,102,241,.12)"><i class="fas fa-clipboard-check" style="color:#6366f1"></i></div>
    <div class="stat-body">
      <div class="stat-value">{{ $totalInspeksi }}</div>
      <div class="stat-label">Total Inspeksi</div>
    </div>
  </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-top:24px">
  {{-- Sertifikat akan expired --}}
  <div class="card">
    <div class="card-header">
      <span class="card-title"><i class="fas fa-exclamation-triangle" style="color:var(--gold)"></i> Sertifikat Akan Expired</span>
    </div>
    <div class="card-body" style="padding:0">
      @if($warningList->isEmpty())
        <div style="padding:20px; text-align:center; color:var(--text-muted)">Tidak ada sertifikat yang akan expired.</div>
      @else
      <table class="table">
        <thead><tr><th>No. Sertifikat</th><th>Pemilik</th><th>Tgl Habis</th></tr></thead>
        <tbody>
          @foreach($warningList as $s)
          <tr>
            <td><a href="{{ route('officer.sertifikat.show',$s->id) }}">{{ $s->nomor_sertifikat }}</a></td>
            <td>{{ $s->nama_pemilik }}</td>
            <td><span class="badge badge-warning">{{ \Carbon\Carbon::parse($s->tanggal_kadaluwarsa)->format('d/m/Y') }}</span></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </div>

  {{-- Inspeksi terbaru --}}
  <div class="card">
    <div class="card-header">
      <span class="card-title"><i class="fas fa-clipboard-list" style="color:var(--navy)"></i> Inspeksi Terbaru</span>
    </div>
    <div class="card-body" style="padding:0">
      @if($recentInspeksi->isEmpty())
        <div style="padding:20px; text-align:center; color:var(--text-muted)">Belum ada data inspeksi.</div>
      @else
      <table class="table">
        <thead><tr><th>No. Inspeksi</th><th>Perusahaan</th><th>Tgl Inspeksi</th></tr></thead>
        <tbody>
          @foreach($recentInspeksi as $i)
          <tr>
            <td><a href="{{ route('officer.inspeksi.show',$i->id) }}">#{{ $i->id }}</a></td>
            <td>{{ $i->nama_perusahaan }}</td>
            <td>{{ \Carbon\Carbon::parse($i->tanggal)->format('d/m/Y') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </div>
</div>
@endsection
