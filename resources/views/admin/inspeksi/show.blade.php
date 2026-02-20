@extends('layouts.internal')
@section('title','Detail Inspeksi')
@section('breadcrumb','Detail Inspeksi')
@section('content')
<div class="page-header">
  <div><div class="page-title">Detail Inspeksi</div><div class="page-subtitle">{{ $inspeksi->nama_perusahaan }}</div></div>
  <div style="display:flex;gap:8px">
    <a href="{{ route('admin.inspeksi.edit',$inspeksi) }}" class="btn btn-primary"><i class="fas fa-pen"></i> Edit</a>
    <a href="{{ route('admin.inspeksi.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</div>
<div class="card" style="max-width:680px">
  <div class="card-header"><span class="card-title">Informasi Inspeksi</span></div>
  <div class="card-body">
    <div class="detail-grid">
      <div class="detail-label">Nama Perusahaan</div><div class="detail-value">{{ $inspeksi->nama_perusahaan }}</div>
      <div class="detail-label">Akun User</div><div class="detail-value">{{ $inspeksi->owner?->name }}</div>
      <div class="detail-label">Tanggal</div><div class="detail-value">{{ $inspeksi->tanggal?->format('d F Y') }}</div>
      <div class="detail-label">Kategori</div><div class="detail-value"><span class="badge" style="background:#e0f2fe;color:#0369a1">{{ $inspeksi->kategori }}</span></div>
      <div class="detail-label">Jenis Sertifikat</div><div class="detail-value">{{ $inspeksi->jenis_sertifikat }}</div>
      <div class="detail-label">Status Berkas</div><div class="detail-value">
        <span class="badge badge-{{ $inspeksi->status_berkas==='Terkirim'?'terkirim':'tidak-ada' }}">{{ $inspeksi->status_berkas }}</span>
      </div>
      <div class="detail-label">Berkas</div><div class="detail-value">
        @if($inspeksi->berkas_path)
          <a href="{{ Storage::url($inspeksi->berkas_path) }}" target="_blank" class="btn btn-outline btn-sm"><i class="fas fa-file-arrow-down"></i> Unduh</a>
        @else
          <span style="color:var(--text-muted)">Tidak ada berkas</span>
        @endif
      </div>
      <div class="detail-label">Dibuat Oleh</div><div class="detail-value">{{ $inspeksi->creator?->name ?? '-' }}</div>
      <div class="detail-label">Dibuat Pada</div><div class="detail-value">{{ $inspeksi->created_at?->format('d F Y H:i') }}</div>
    </div>
  </div>
</div>
@endsection
