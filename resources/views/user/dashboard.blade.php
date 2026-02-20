@extends('layouts.internal')
@section('title','Dashboard')
@section('breadcrumb','Dashboard')
@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Selamat Datang, {{ auth()->user()->name }}</div>
    <div class="page-subtitle">Ringkasan data sertifikat dan inspeksi Anda</div>
  </div>
</div>

{{-- Stats --}}
<div class="stats-grid">
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
    <div class="stat-icon" style="background:rgba(234,179,8,.12)"><i class="fas fa-exclamation-triangle" style="color:#eab308"></i></div>
    <div class="stat-body">
      <div class="stat-value">{{ $sertifikatWarning }}</div>
      <div class="stat-label">Akan Expired</div>
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
    <div class="stat-icon" style="background:rgba(99,102,241,.12)"><i class="fas fa-clipboard-check" style="color:#6366f1"></i></div>
    <div class="stat-body">
      <div class="stat-value">{{ $totalInspeksi }}</div>
      <div class="stat-label">Total Inspeksi</div>
    </div>
  </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-top:24px">
  {{-- Sertifikat warning --}}
  <div class="card">
    <div class="card-header">
      <span class="card-title"><i class="fas fa-exclamation-triangle" style="color:var(--gold)"></i> Sertifikat Akan Expired</span>
      <a href="{{ route('user.sertifikat.index') }}" style="font-size:12px; color:var(--text-muted)">Lihat semua</a>
    </div>
    <div class="card-body" style="padding:0">
      @if($warningList->isEmpty())
        <div style="padding:20px; text-align:center; color:var(--text-muted)">Tidak ada sertifikat yang akan expired.</div>
      @else
      <table class="table">
        <thead><tr><th>No. Sertifikat</th><th>Jenis</th><th>Tgl Habis</th></tr></thead>
        <tbody>
          @foreach($warningList as $s)
          <tr>
            <td><a href="{{ route('user.sertifikat.show',$s->id) }}">{{ $s->nomor_sertifikat }}</a></td>
            <td>{{ $s->jenis_sertifikat }}</td>
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
      <a href="{{ route('user.inspeksi.index') }}" style="font-size:12px; color:var(--text-muted)">Lihat semua</a>
    </div>
    <div class="card-body" style="padding:0">
      @if($recentInspeksi->isEmpty())
        <div style="padding:20px; text-align:center; color:var(--text-muted)">Belum ada data inspeksi.</div>
      @else
      <table class="table">
        <thead><tr><th>No. Inspeksi</th><th>Kategori</th><th>Tgl Inspeksi</th></tr></thead>
        <tbody>
          @foreach($recentInspeksi as $i)
          <tr>
            <td><a href="{{ route('user.inspeksi.show',$i->id) }}">#{{ $i->id }}</a></td>
            <td>{{ $i->kategori }}</td>
            <td>{{ \Carbon\Carbon::parse($i->tanggal)->format('d/m/Y') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </div>
</div>

{{-- Officer Info --}}
@if(auth()->user()->officer)
<div class="card" style="margin-top:20px">
  <div class="card-header"><span class="card-title"><i class="fas fa-user-tie" style="color:var(--navy)"></i> Officer Penanggungjawab</span></div>
  <div class="card-body">
    <div style="display:flex; align-items:center; gap:12px">
      <div style="width:40px; height:40px; background:var(--navy); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:600">
        {{ strtoupper(substr(auth()->user()->officer->name,0,1)) }}
      </div>
      <div>
        <div style="font-weight:600">{{ auth()->user()->officer->name }}</div>
        <div style="font-size:12px; color:var(--text-muted)">{{ auth()->user()->officer->username }}</div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection
