@extends('layouts.internal')
@section('title','Tambah Inspeksi')
@section('breadcrumb','Inspeksi / Tambah')
@section('content')
<div class="page-header">
  <div><div class="page-title">Tambah Inspeksi</div></div>
  <div class="page-actions"><a href="{{ route('officer.inspeksi.index') }}" class="btn btn-sm" style="background:var(--border); color:var(--text)"><i class="fas fa-arrow-left"></i> Kembali</a></div>
</div>
<div class="card" style="max-width:720px">
  <div class="card-body">
    @if($errors->any())
    <div class="alert alert-danger"><ul style="margin:0; padding-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    <form method="POST" action="{{ route('officer.inspeksi.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label class="form-label">User Pengguna <span style="color:#ef4444">*</span></label>
        <select name="user_id" class="form-select" required>
          <option value="">-- Pilih Pengguna --</option>
          @foreach($assignedUsers as $u)
          <option value="{{ $u->id }}" {{ old('user_id')==$u->id?'selected':'' }}>{{ $u->name }} ({{ $u->username }})</option>
          @endforeach
        </select>
        @error('user_id')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Nama Perusahaan <span style="color:#ef4444">*</span></label>
        <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan') }}" required>
        @error('nama_perusahaan')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Kategori <span style="color:#ef4444">*</span></label>
          <select name="kategori" class="form-select" required>
            <option value="">-- Pilih --</option>
            <option value="Inspeksi" {{ old('kategori')=='Inspeksi'?'selected':'' }}>Inspeksi</option>
            <option value="Surveilan" {{ old('kategori')=='Surveilan'?'selected':'' }}>Surveilan</option>
          </select>
          @error('kategori')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Jenis Sertifikat <span style="color:#ef4444">*</span></label>
          <select name="jenis_sertifikat" class="form-select" required>
            <option value="">-- Pilih --</option>
            @foreach($jenisList as $j)
            <option value="{{ $j }}" {{ old('jenis_sertifikat')==$j?'selected':'' }}>{{ $j }}</option>
            @endforeach
          </select>
          @error('jenis_sertifikat')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Tanggal Inspeksi <span style="color:#ef4444">*</span></label>
        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required style="max-width:220px">
        @error('tanggal')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Upload Berkas <span style="font-size:11px; color:var(--text-muted)">(PDF/DOC/DOCX, maks 5MB)</span></label>
        <input type="file" name="berkas" class="form-control" accept=".pdf,.doc,.docx">
        @error('berkas')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div style="display:flex; gap:8px; justify-content:flex-end; padding-top:8px">
        <a href="{{ route('officer.inspeksi.index') }}" class="btn btn-sm" style="background:var(--border); color:var(--text)">Batal</a>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection
