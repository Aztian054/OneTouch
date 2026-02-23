@extends('layouts.internal')
@section('title','Tambah Berita')
@section('breadcrumb','Tambah Berita')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Tambah Berita</div>
    <div class="page-subtitle">Tambahkan berita atau kegiatan baru</div>
  </div>
  <a href="{{ route('admin.news.index') }}" class="btn btn-outline">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Judul <span class="req">*</span></label>
          <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Masukkan judul berita">
        </div>

        <div class="form-group">
          <label class="form-label">Tanggal Kegiatan</label>
          <input type="date" name="event_date" class="form-control" value="{{ old('event_date') }}">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="4" placeholder="Masukkan deskripsi berita">{{ old('description') }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Gambar</label>
        <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif">
        <div class="form-hint">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</div>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Urutan <span class="req">*</span></label>
          <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0" required>
          <div class="form-hint">Semakin kecil urutan, semakin atas tampilan.</div>
        </div>

        <div class="form-group">
          <label class="form-label">Status</label>
          <select name="is_active" class="form-select">
            <option value="1" {{ old('is_active', 1) ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ old('is_active', 1) ? '' : 'selected' }}>Tidak Aktif</option>
          </select>
        </div>
      </div>

      <div style="display:flex; gap:10px; margin-top:20px;">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Simpan Berita
        </button>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection