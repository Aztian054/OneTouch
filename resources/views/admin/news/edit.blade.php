@extends('layouts.internal')
@section('title','Edit Berita')
@section('breadcrumb','Edit Berita')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Edit Berita</div>
    <div class="page-subtitle">Edit berita atau kegiatan</div>
  </div>
  <a href="{{ route('admin.news.index') }}" class="btn btn-outline">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Judul <span class="req">*</span></label>
          <input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}" required placeholder="Masukkan judul berita">
        </div>

        <div class="form-group">
          <label class="form-label">Tanggal Kegiatan</label>
          <input type="date" name="event_date" class="form-control" value="{{ old('event_date', $news->event_date ? $news->event_date->format('Y-m-d') : '') }}">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="4" placeholder="Masukkan deskripsi berita">{{ old('description', $news->description) }}</textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Gambar</label>
        <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif">
        <div class="form-hint">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB. Kosongkan untuk tetap menggunakan gambar lama.</div>
        @if($news->image)
        <div style="margin-top:10px;">
          <div style="font-size:12px; color:var(--text-muted); margin-bottom:5px;">Gambar saat ini:</div>
          <div style="width:150px; height:100px; background:url('{{ asset($news->image) }}') center/cover; border-radius:6px; border:1px solid var(--border);"></div>
        </div>
        @endif
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Urutan <span class="req">*</span></label>
          <input type="number" name="order" class="form-control" value="{{ old('order', $news->order) }}" min="0" required>
          <div class="form-hint">Semakin kecil urutan, semakin atas tampilan.</div>
        </div>

        <div class="form-group">
          <label class="form-label">Status</label>
          <select name="is_active" class="form-select">
            <option value="1" {{ old('is_active', $news->is_active) ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ old('is_active', $news->is_active) ? '' : 'selected' }}>Tidak Aktif</option>
          </select>
        </div>
      </div>

      <div style="display:flex; gap:10px; margin-top:20px;">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Simpan Perubahan
        </button>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection