@extends('layouts.internal')
@section('title','Manajemen Inspeksi')
@section('breadcrumb','Inspeksi')
@section('content')
<div class="page-header">
  <div><div class="page-title">Manajemen Inspeksi</div><div class="page-subtitle">Total: {{ $inspeksis->total() }} data</div></div>
  <a href="{{ route('admin.inspeksi.create') }}" class="btn btn-gold"><i class="fas fa-plus"></i> Tambah Inspeksi</a>
</div>
<div class="card">
  <div class="card-body" style="padding-bottom:0">
    <form method="GET" class="filter-bar">
      <div class="search-wrap"><i class="fas fa-search"></i>
        <input type="text" name="search" class="form-control" placeholder="Cari perusahaan..." value="{{ request('search') }}">
      </div>
      <select name="kategori" class="form-select">
        <option value="">Semua Kategori</option>
        <option value="Inspeksi" {{ request('kategori')=='Inspeksi'?'selected':'' }}>Inspeksi</option>
        <option value="Surveilan" {{ request('kategori')=='Surveilan'?'selected':'' }}>Surveilan</option>
      </select>
      <select name="jenis" class="form-select">
        <option value="">Semua Jenis</option>
        @foreach($jenisList as $j)
        <option value="{{ $j }}" {{ request('jenis')==$j?'selected':'' }}>{{ $j }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
      <a href="{{ route('admin.inspeksi.index') }}" class="btn btn-outline"><i class="fas fa-times"></i></a>
    </form>
  </div>
  <div class="table-wrap">
    <table class="data-table">
      <thead><tr><th>No</th><th>Perusahaan</th><th>Tanggal</th><th>Kategori</th><th>Jenis</th><th>Berkas</th><th>Petugas</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($inspeksis as $i => $ins)
        <tr>
          <td>{{ $inspeksis->firstItem() + $i }}</td>
          <td>{{ $ins->nama_perusahaan }}</td>
          <td>{{ $ins->tanggal?->format('d/m/Y') }}</td>
          <td><span class="badge" style="background:#e0f2fe;color:#0369a1">{{ $ins->kategori }}</span></td>
          <td>{{ $ins->jenis_sertifikat }}</td>
          <td><span class="badge badge-{{ $ins->status_berkas==='Terkirim'?'terkirim':'tidak-ada' }}">{{ $ins->status_berkas }}</span></td>
          <td style="font-size:12px; color:var(--text-muted)">{{ $ins->creator?->name ?? '-' }}</td>
          <td><div style="display:flex;gap:4px">
            <a href="{{ route('admin.inspeksi.show',$ins) }}" class="btn btn-outline btn-xs"><i class="fas fa-eye"></i></a>
            <a href="{{ route('admin.inspeksi.edit',$ins) }}" class="btn btn-primary btn-xs"><i class="fas fa-pen"></i></a>
            <form method="POST" action="{{ route('admin.inspeksi.destroy',$ins) }}" onsubmit="return confirm('Hapus?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
            </form>
          </div></td>
        </tr>
        @empty
        <tr><td colspan="8"><div class="empty-state"><i class="fas fa-clipboard-check"></i><p>Belum ada data inspeksi</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($inspeksis->hasPages())
  <div style="padding:16px 20px; border-top:1px solid var(--border)">{{ $inspeksis->links('vendor.pagination.custom') }}</div>
  @endif
</div>
@endsection
