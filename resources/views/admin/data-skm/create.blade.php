@extends('layouts.internal')
@section('title','Tambah Data SKM')
@section('breadcrumb','Tambah Data SKM')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Tambah Data SKM</div>
    <div class="page-subtitle">Tambahkan data Target dan Realisasi SKM untuk tahun tertentu</div>
  </div>
  <a href="{{ route('admin.data-skm.index') }}" class="btn btn-outline">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('admin.data-skm.store') }}">
      @csrf

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Tahun <span class="req">*</span></label>
          <input type="number" name="tahun" class="form-control" value="{{ old('tahun', date('Y')) }}" min="2000" max="2100" required>
        </div>

        <div class="form-group">
          <label class="form-label">Target IKM <span class="req">*</span></label>
          <input type="number" name="target" class="form-control" value="{{ old('target') }}" min="1" max="5" step="0.01" required>
          <div class="form-hint">Skala 1-5</div>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Realisasi IKM <span class="req">*</span></label>
        <input type="number" name="realisasi" class="form-control" value="{{ old('realisasi') }}" min="1" max="5" step="0.01" required>
        <div class="form-hint">Skala 1-5</div>
      </div>

      <div style="display:flex; gap:10px; margin-top:20px;">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Simpan Data
        </button>
        <a href="{{ route('admin.data-skm.index') }}" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection