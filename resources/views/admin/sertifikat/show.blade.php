@extends('layouts.internal')
@section('title','Detail Sertifikat')
@section('breadcrumb','Detail Sertifikat')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Detail Sertifikat</div>
    <div class="page-subtitle">{{ $sertifikat->nomor_sertifikat }}</div>
  </div>
  <div style="display:flex; gap:8px">
    <a href="{{ route('admin.sertifikat.edit', $sertifikat) }}" class="btn btn-primary"><i class="fas fa-pen"></i> Edit</a>
    <a href="{{ route('admin.sertifikat.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</div>

<div class="card" style="max-width:720px">
  <div class="card-header">
    <span class="card-title">Informasi Sertifikat</span>
    <span class="badge badge-{{ $sertifikat->status_masa }}">{{ strtoupper($sertifikat->status_masa) }}</span>
  </div>
  <div class="card-body">
    <div class="detail-grid">
      <div class="detail-label">Nama Pemilik</div><div class="detail-value">{{ $sertifikat->nama_pemilik }}</div>
      <div class="detail-label">Akun User</div><div class="detail-value">{{ $sertifikat->owner?->name }} ({{ $sertifikat->owner?->username }})</div>
      <div class="detail-label">Perusahaan</div><div class="detail-value">{{ $sertifikat->owner?->company_name ?? '-' }}</div>
      <div class="detail-label">Nomor Sertifikat</div><div class="detail-value" style="font-family:monospace">{{ $sertifikat->nomor_sertifikat }}</div>
      <div class="detail-label">Jenis Sertifikat</div><div class="detail-value">{{ $sertifikat->jenis_sertifikat }}</div>
      <div class="detail-label">Grade</div><div class="detail-value"><span class="badge" style="background:#e0f2fe; color:#0369a1">{{ $sertifikat->grade }}</span></div>
      <div class="detail-label">Ruang Lingkup</div><div class="detail-value">{{ $sertifikat->ruang_lingkup }}</div>
      <div class="detail-label">Tanggal Terbit</div><div class="detail-value">{{ $sertifikat->tanggal_terbit?->format('d F Y') }}</div>
      <div class="detail-label">Tanggal Kadaluwarsa</div><div class="detail-value">{{ $sertifikat->tanggal_kadaluwarsa?->format('d F Y') }}</div>
      <div class="detail-label">Status Masa</div><div class="detail-value"><span class="badge badge-{{ $sertifikat->status_masa }}">{{ strtoupper($sertifikat->status_masa) }}</span></div>
      <div class="detail-label">Status Proses</div><div class="detail-value"><span class="badge badge-{{ strtolower($sertifikat->status_proses) }}">{{ $sertifikat->status_proses }}</span></div>
      <div class="detail-label">Status Berkas</div>
      <div class="detail-value">
        <span class="badge badge-{{ $sertifikat->status_berkas==='Terkirim'?'terkirim':'tidak-ada' }}">{{ $sertifikat->status_berkas ?? 'Tidak Ada' }}</span>
      </div>
      <div class="detail-label">Berkas Dokumen</div>
      <div class="detail-value">
        @if($sertifikat->berkas_path)
          <a href="{{ Storage::url($sertifikat->berkas_path) }}" target="_blank" class="btn btn-outline btn-sm"><i class="fas fa-file-arrow-down"></i> Lihat / Unduh Berkas</a>
        @else
          <span style="color:var(--text-muted)">Tidak ada berkas</span>
        @endif
      </div>
      <div class="detail-label">Dibuat Oleh</div><div class="detail-value">{{ $sertifikat->creator?->name ?? '-' }}</div>
      <div class="detail-label">Dibuat Pada</div><div class="detail-value">{{ $sertifikat->created_at?->format('d F Y H:i') }}</div>
    </div>
  </div>
</div>
@endsection
