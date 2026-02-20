@extends('layouts.internal')
@section('title','Detail Sertifikat')
@section('breadcrumb','Sertifikat / Detail')
@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Detail Sertifikat</div>
    <div class="page-subtitle">{{ $sertifikat->nomor_sertifikat }}</div>
  </div>
  <div class="page-actions">
    <a href="{{ route('user.sertifikat.index') }}" class="btn btn-sm" style="background:var(--border); color:var(--text)"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</div>

<div class="card" style="max-width:760px">
  <div class="card-header">
    <span class="card-title">Informasi Sertifikat</span>
    <span class="badge badge-{{ $sertifikat->status_masa==='aktif'?'success':($sertifikat->status_masa==='warning'?'warning':'danger') }}">{{ strtoupper($sertifikat->status_masa) }}</span>
  </div>
  <div class="card-body">
    <div class="detail-grid">
      <div class="detail-label">Nomor Sertifikat</div>
      <div class="detail-value" style="font-family:monospace">{{ $sertifikat->nomor_sertifikat }}</div>

      <div class="detail-label">Nama Pemilik</div>
      <div class="detail-value">{{ $sertifikat->nama_pemilik }}</div>

      <div class="detail-label">Ruang Lingkup</div>
      <div class="detail-value">{{ $sertifikat->ruang_lingkup }}</div>

      <div class="detail-label">Jenis Sertifikat</div>
      <div class="detail-value">{{ $sertifikat->jenis_sertifikat }}</div>

      <div class="detail-label">Grade</div>
      <div class="detail-value"><span class="badge" style="background:#e0f2fe; color:#0369a1">{{ $sertifikat->grade }}</span></div>

      <div class="detail-label">Tanggal Terbit</div>
      <div class="detail-value">{{ $sertifikat->tanggal_terbit?->format('d F Y') }}</div>

      <div class="detail-label">Tanggal Kadaluwarsa</div>
      <div class="detail-value">{{ $sertifikat->tanggal_kadaluwarsa?->format('d F Y') }}
        @if($sertifikat->status_masa !== 'aktif')
          <span style="font-size:11px; color:var(--text-muted); margin-left:4px">
            @if($sertifikat->status_masa === 'expired')
              (sudah berakhir {{ $sertifikat->tanggal_kadaluwarsa?->diffForHumans() }})
            @else
              (berakhir {{ $sertifikat->tanggal_kadaluwarsa?->diffForHumans() }})
            @endif
          </span>
        @endif
      </div>

      <div class="detail-label">Status Masa</div>
      <div class="detail-value">
        <span class="badge badge-{{ $sertifikat->status_masa==='aktif'?'success':($sertifikat->status_masa==='warning'?'warning':'danger') }}">{{ strtoupper($sertifikat->status_masa) }}</span>
      </div>

      <div class="detail-label">Status Berkas</div>
      <div class="detail-value">
        <span class="badge" style="background:{{ $sertifikat->berkas_path ? '#dcfce7' : '#f1f5f9' }}; color:{{ $sertifikat->berkas_path ? '#166534' : '#475569' }}">
          {{ $sertifikat->berkas_path ? 'Terkirim' : 'Tidak Ada' }}
        </span>
      </div>

      <div class="detail-label">Berkas Dokumen</div>
      <div class="detail-value">
        @if($sertifikat->berkas_path)
          <a href="{{ Storage::url($sertifikat->berkas_path) }}" target="_blank" class="btn btn-outline btn-sm">
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
