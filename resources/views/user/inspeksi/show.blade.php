@extends('layouts.internal')
@section('title','Detail Inspeksi')
@section('breadcrumb','Inspeksi / Detail')
@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Detail Inspeksi</div>
    <div class="page-subtitle">{{ $inspeksi->nama_perusahaan }}</div>
  </div>
  <div class="page-actions">
    <a href="{{ route('user.inspeksi.index') }}" class="btn btn-sm" style="background:var(--border); color:var(--text)"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</div>

<div class="card" style="max-width:760px">
  <div class="card-header"><span class="card-title">Informasi Inspeksi</span></div>
  <div class="card-body">
    <div class="detail-grid">
      <div class="detail-label">ID Inspeksi</div>
      <div class="detail-value">#{{ $inspeksi->id }}</div>

      <div class="detail-label">Nama Perusahaan</div>
      <div class="detail-value">{{ $inspeksi->nama_perusahaan }}</div>

      <div class="detail-label">Kategori</div>
      <div class="detail-value"><span class="badge badge-primary">{{ $inspeksi->kategori }}</span></div>

      <div class="detail-label">Jenis Sertifikat</div>
      <div class="detail-value">{{ $inspeksi->jenis_sertifikat }}</div>

      <div class="detail-label">Tanggal Inspeksi</div>
      <div class="detail-value">{{ $inspeksi->tanggal?->format('d F Y') }}</div>

      <div class="detail-label">Status Berkas</div>
      <div class="detail-value">
        <span class="badge" style="background:{{ $inspeksi->berkas_path ? '#dcfce7' : '#f1f5f9' }}; color:{{ $inspeksi->berkas_path ? '#166534' : '#475569' }}">
          {{ $inspeksi->berkas_path ? 'Terkirim' : 'Tidak Ada' }}
        </span>
      </div>

      <div class="detail-label">Berkas Dokumen</div>
      <div class="detail-value">
        @if($inspeksi->berkas_path)
          <a href="{{ Storage::url($inspeksi->berkas_path) }}" target="_blank" class="btn btn-outline btn-sm">
            <i class="fas fa-file-arrow-down"></i> Lihat / Unduh Berkas
          </a>
        @else
          <span style="color:var(--text-muted)">Tidak ada berkas</span>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
