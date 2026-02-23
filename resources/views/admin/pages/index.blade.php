@extends('layouts.internal')
@section('title', 'Manajemen Halaman Publik')
@section('breadcrumb', 'Halaman Publik')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Manajemen Halaman Publik</div>
    <div class="page-subtitle">Kelola konten halaman portal publik</div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">Daftar Halaman</div>
  </div>
  <div class="card-body">
    <div class="table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>Urutan</th>
            <th>Slug</th>
            <th>Judul Halaman</th>
            <th>Subjudul</th>
            <th>Status</th>
            <th style="text-align:right;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pages as $page)
          <tr>
            <td><span class="badge" style="background:#f1f5f9; color:#0f172a;">{{ $page->order }}</span></td>
            <td><code style="font-size:12px; background:#f8fafc; padding:4px 8px; border-radius:4px;">{{ $page->slug }}</code></td>
            <td><strong>{{ $page->title }}</strong></td>
            <td>{{ $page->subtitle ?? '-' }}</td>
            <td>
              <span class="badge {{ $page->is_active ? 'badge-aktif' : 'badge-expired' }}">
                {{ $page->is_active ? 'Aktif' : 'Nonaktif' }}
              </span>
            </td>
            <td style="text-align:right;">
              <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-pen"></i> Edit
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" style="text-align:center; padding:40px;">
              <i class="fas fa-file-lines" style="font-size:40px; opacity:0.3; margin-bottom:12px; display:block;"></i>
              <p style="margin:0; color:var(--text-muted);">Belum ada halaman publik</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection