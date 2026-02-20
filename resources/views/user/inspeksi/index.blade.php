@extends('layouts.internal')
@section('title','Inspeksi Saya')
@section('breadcrumb','Inspeksi')
@section('content')
<div class="page-header">
  <div><div class="page-title">Inspeksi Saya</div><div class="page-subtitle">Daftar inspeksi yang terkait dengan akun Anda</div></div>
</div>

{{-- Filter --}}
<div class="card" style="margin-bottom:16px">
  <div class="card-body" style="padding:12px 16px">
    <form method="GET" style="display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end">
      <div class="form-group" style="margin:0; flex:1; min-width:160px">
        <label class="form-label" style="font-size:11px">Cari</label>
        <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="Nama perusahaan…">
      </div>
      <div class="form-group" style="margin:0; min-width:120px">
        <label class="form-label" style="font-size:11px">Kategori</label>
        <select name="kategori" class="form-select form-select-sm">
          <option value="">Semua</option>
          <option value="Inspeksi" {{ request('kategori')=='Inspeksi'?'selected':'' }}>Inspeksi</option>
          <option value="Surveilan" {{ request('kategori')=='Surveilan'?'selected':'' }}>Surveilan</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
      <a href="{{ route('user.inspeksi.index') }}" class="btn btn-sm" style="background:var(--border); color:var(--text)"><i class="fas fa-times"></i></a>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body" style="padding:0">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>ID</th>
          <th>Perusahaan</th>
          <th>Kategori</th>
          <th>Jenis Sertifikat</th>
          <th>Tanggal</th>
          <th>Berkas</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($inspeksis as $i)
        <tr>
          <td>{{ $inspeksis->firstItem() + $loop->index }}</td>
          <td>#{{ $i->id }}</td>
          <td>{{ $i->nama_perusahaan }}</td>
          <td><span class="badge badge-primary">{{ $i->kategori }}</span></td>
          <td>{{ $i->jenis_sertifikat }}</td>
          <td>{{ $i->tanggal?->format('d/m/Y') }}</td>
          <td>
            @if($i->berkas_path)
              <span class="badge" style="background:#dcfce7; color:#166534"><i class="fas fa-paperclip"></i> Ada</span>
            @else
              <span style="color:var(--text-muted); font-size:12px">-</span>
            @endif
          </td>
          <td>
            <a href="{{ route('user.inspeksi.show',$i->id) }}" class="btn btn-icon btn-sm" title="Detail"><i class="fas fa-eye"></i></a>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center; color:var(--text-muted); padding:32px">Tidak ada data inspeksi.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($inspeksis->hasPages())
  <div class="card-footer">{{ $inspeksis->withQueryString()->links('vendor.pagination.custom') }}</div>
  @endif
</div>
@endsection
