@extends('layouts.internal')
@section('title','Berita & Kegiatan')
@section('breadcrumb','Berita & Kegiatan')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Berita & Kegiatan</div>
    <div class="page-subtitle">Kelola konten berita dan kegiatan untuk ditampilkan di Media Page & Beranda</div>
  </div>
  <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Berita
  </a>
</div>

<div class="card">
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th style="width:50px">#</th>
          <th>Gambar</th>
          <th>Judul</th>
          <th>Tanggal Kegiatan</th>
          <th>Urutan</th>
          <th>Status</th>
          <th style="text-align:right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($news as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>
            @if($item->image)
            <div style="width:80px; height:60px; background:url('{{ asset($item->image) }}') center/cover; border-radius:6px;"></div>
            @else
            <div style="width:80px; height:60px; background:var(--surface-2); border-radius:6px; display:flex; align-items:center; justify-content:center; color:var(--text-muted); font-size:11px;">No Image</div>
            @endif
          </td>
          <td>
            <div style="font-weight:600;">{{ $item->title }}</div>
            @if($item->description)
            <div style="font-size:12px; color:var(--text-muted); max-width:300px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ Str::limit($item->description, 80) }}</div>
            @endif
          </td>
          <td>{{ $item->event_date ? $item->event_date->format('d/m/Y') : '-' }}</td>
          <td>{{ $item->order }}</td>
          <td>
            <span class="badge badge-{{ $item->is_active ? 'aktif' : 'expired' }}">
              {{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}
            </span>
          </td>
          <td style="text-align:right;">
            <div style="display:flex; gap:5px; justify-content:flex-end;">
              <a href="{{ route('admin.news.edit', $item) }}" class="btn-icon btn-warning" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              <form action="{{ route('admin.news.destroy', $item) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-icon btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus berita ini?')">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center; color:var(--text-muted); padding:40px;">Belum ada berita</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection