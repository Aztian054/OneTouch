@extends('layouts.internal')
@section('title', 'Edit Halaman: ' . $page->title)
@section('breadcrumb', 'Halaman Publik')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Edit Halaman</div>
    <div class="page-subtitle">{{ $page->title }} ({{ $page->slug }})</div>
  </div>
</div>

<form method="POST" action="{{ route('admin.pages.update', $page) }}">
  @csrf
  @method('PUT')

  <div class="card" style="margin-bottom:20px;">
    <div class="card-header"><span class="card-title">Informasi Dasar</span></div>
    <div class="card-body">
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Judul Halaman <span class="req">*</span></label>
          <input type="text" name="title" value="{{ old('title', $page->title) }}" class="form-control" required>
          @error('title') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
          <label class="form-label">Slug (URL)</label>
          <input type="text" value="{{ $page->slug }}" class="form-control" disabled style="background:#f1f5f9; cursor:not-allowed;">
          <div class="form-hint">Slug tidak dapat diubah untuk menjaga URL konsisten</div>
        </div>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Subjudul</label>
          <input type="text" name="subtitle" value="{{ old('subtitle', $page->subtitle) }}" class="form-control" placeholder="Tagline atau deskripsi singkat">
          @error('subtitle') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
          <label class="form-label">Hero Image (URL)</label>
          <input type="text" name="hero_image" value="{{ old('hero_image', $page->hero_image) }}" class="form-control" placeholder="URL gambar banner">
          <div class="form-hint">Contoh: /assets/bg-dark.jpg</div>
          @error('hero_image') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Meta Title (SEO)</label>
          <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" class="form-control" placeholder="Judul untuk search engine">
          @error('meta_title') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
          <label class="form-label">Meta Description (SEO)</label>
          <input type="text" name="meta_description" value="{{ old('meta_description', $page->meta_description) }}" class="form-control" placeholder="Deskripsi untuk search engine">
          @error('meta_description') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Urutan Tampilan <span class="req">*</span></label>
          <input type="number" name="order" value="{{ old('order', $page->order) }}" class="form-control" min="0" required>
          <div class="form-hint">Angka kecil akan tampil di menu lebih awal</div>
          @error('order') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
          <label class="form-label">Status</label>
          <select name="is_active" class="form-select" required>
            <option value="1" {{ old('is_active', $page->is_active) ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ !old('is_active', $page->is_active) ? 'selected' : '' }}>Nonaktif</option>
          </select>
          @error('is_active') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><span class="card-title">Konten</span></div>
    <div class="card-body">
      <div class="form-group">
        <label class="form-label">Konten Halaman</label>
        <div class="form-hint" style="margin-bottom:8px;">
          Anda bisa menggunakan HTML untuk formatting (tag <p>, <strong>, <a>, dll)
        </div>
        <textarea name="content" rows="15" class="form-control" placeholder="Tulis konten halaman di sini...">{{ old('content', $page->content) }}</textarea>
        @error('content') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
      </div>
    </div>
  </div>

  <div style="display:flex; gap:10px; margin-top:20px;">
    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline">
      <i class="fas fa-times"></i> Batal
    </a>
    <button type="submit" class="btn btn-primary">
      <i class="fas fa-save"></i> Simpan Perubahan
    </button>
  </div>
</form>
@endsection