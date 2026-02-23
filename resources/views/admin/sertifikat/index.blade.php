@extends('layouts.internal')
@section('title','Manajemen Sertifikat')
@section('breadcrumb','Sertifikat')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Manajemen Sertifikat</div>
    <div class="page-subtitle">Total: {{ $sertifikats->total() }} data sertifikat</div>
  </div>
  <a href="{{ route('admin.sertifikat.create') }}" class="btn btn-gold">
    <i class="fas fa-plus"></i> Tambah Sertifikat
  </a>
</div>

<div class="card">
  <div class="card-body" style="padding-bottom:0">
    <form method="GET" class="filter-bar">
      <div class="search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" name="search" class="form-control" placeholder="Cari nama / nomor..." value="{{ request('search') }}">
      </div>
      <select name="jenis" class="form-select">
        <option value="">Semua Jenis</option>
        @foreach($jenisList as $j)
        <option value="{{ $j }}" {{ request('jenis')==$j?'selected':'' }}>{{ $j }}</option>
        @endforeach
      </select>
      <select name="status_masa" class="form-select">
        <option value="">Semua Status</option>
        <option value="aktif"   {{ request('status_masa')=='aktif'?'selected':'' }}>Aktif</option>
        <option value="warning" {{ request('status_masa')=='warning'?'selected':'' }}>Warning</option>
        <option value="expired" {{ request('status_masa')=='expired'?'selected':'' }}>Expired</option>
      </select>
      <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
      <a href="{{ route('admin.sertifikat.index') }}" class="btn btn-outline"><i class="fas fa-times"></i></a>
    </form>
  </div>
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>No</th><th>Nama Pemilik</th><th>No. Sertifikat</th><th>Jenis</th>
          <th>Grade</th><th>Kadaluwarsa</th><th>Status</th><th>Keterangan</th><th>Proses</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sertifikats as $i => $s)
        <tr>
          <td>{{ $sertifikats->firstItem() + $i }}</td>
          <td>
            <div style="font-weight:500">{{ $s->nama_pemilik }}</div>
            <div style="font-size:12px; color:var(--text-muted)">{{ $s->owner?->company_name }}</div>
          </td>
          <td style="font-family:monospace; font-size:12px">{{ $s->nomor_sertifikat }}</td>
          <td>{{ $s->jenis_sertifikat }}</td>
          <td><span class="badge" style="background:#e0f2fe; color:#0369a1">{{ $s->grade }}</span></td>
          <td>{{ $s->tanggal_kadaluwarsa?->format('d/m/Y') }}</td>
          <td><span class="badge badge-{{ $s->status_masa }}">{{ $s->status_masa }}</span></td>
          <td style="font-size:12px; color:var(--text-muted);">
            @if($s->status_masa == 'aktif')
              Sertifikat masih berlaku (> 15 hari)
            @elseif($s->status_masa == 'warning')
              Akan kadaluwarsa dalam ≤ 15 hari
            @elseif($s->status_masa == 'expired')
              Sudah kadaluwarsa
            @endif
          </td>
          <td><span class="badge badge-{{ strtolower($s->status_proses) }}">{{ $s->status_proses }}</span></td>
          <td>
            <div style="display:flex; gap:4px">
              <a href="{{ route('admin.sertifikat.show', $s) }}" class="btn btn-outline btn-xs" title="Detail"><i class="fas fa-eye"></i></a>
              <a href="{{ route('admin.sertifikat.edit', $s) }}" class="btn btn-primary btn-xs" title="Edit"><i class="fas fa-pen"></i></a>
              <form method="POST" action="{{ route('admin.sertifikat.destroy', $s) }}" onsubmit="return confirm('Hapus sertifikat ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-xs" title="Hapus"><i class="fas fa-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="10"><div class="empty-state"><i class="fas fa-certificate"></i><p>Belum ada data sertifikat</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($sertifikats->hasPages())
  <div style="padding:16px 20px; border-top:1px solid var(--border)">
    {{ $sertifikats->links('vendor.pagination.custom') }}
  </div>
  @endif
</div>
@endsection
