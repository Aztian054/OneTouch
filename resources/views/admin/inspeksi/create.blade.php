@extends('layouts.internal')
@section('title','Tambah Inspeksi')
@section('breadcrumb','Tambah Inspeksi')
@section('content')
<div class="page-header">
  <div><div class="page-title">Tambah Inspeksi</div></div>
  <a href="{{ route('admin.inspeksi.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card" style="max-width:700px">
  <div class="card-header"><span class="card-title">Formulir Inspeksi</span></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.inspeksi.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Pemilik / User <span class="req">*</span></label>
          <select name="user_id" class="form-select" required>
            <option value="">-- Pilih User --</option>
            @foreach($users as $u)
            <option value="{{ $u->id }}" {{ old('user_id')==$u->id?'selected':'' }}>{{ $u->name }} {{ $u->company_name?"({$u->company_name})":'' }}</option>
            @endforeach
          </select>
          @error('user_id')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Nama Perusahaan <span class="req">*</span></label>
          <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan') }}" required>
          @error('nama_perusahaan')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="form-grid-3">
        <div class="form-group">
          <label class="form-label">Tanggal <span class="req">*</span></label>
          <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
          @error('tanggal')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Kategori <span class="req">*</span></label>
          <select name="kategori" class="form-select" required>
            <option value="Inspeksi" {{ old('kategori')=='Inspeksi'?'selected':'' }}>Inspeksi</option>
            <option value="Surveilan" {{ old('kategori')=='Surveilan'?'selected':'' }}>Surveilan</option>
          </select>
          @error('kategori')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Jenis Sertifikat <span class="req">*</span></label>
          <select name="jenis_sertifikat" class="form-select" required>
            <option value="">-- Jenis --</option>
            @foreach($jenisList as $j)
            <option value="{{ $j }}" {{ old('jenis_sertifikat')==$j?'selected':'' }}>{{ $j }}</option>
            @endforeach
          </select>
          @error('jenis_sertifikat')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Upload Berkas (PDF/DOC, maks 5MB)</label>
        <input type="file" name="berkas" class="form-control" accept=".pdf,.doc,.docx">
        @error('berkas')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div style="display:flex; gap:10px">
        <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> Simpan</button>
        <a href="{{ route('admin.inspeksi.index') }}" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
