@extends('layouts.internal')
@section('title','Edit Inspeksi')
@section('breadcrumb','Edit Inspeksi')
@section('content')
<div class="page-header">
  <div><div class="page-title">Edit Inspeksi</div><div class="page-subtitle">{{ $inspeksi->nama_perusahaan }}</div></div>
  <a href="{{ route('admin.inspeksi.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card" style="max-width:700px">
  <div class="card-header"><span class="card-title">Edit Data Inspeksi</span></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.inspeksi.update',$inspeksi) }}" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Pemilik / User <span class="req">*</span></label>
          <select name="user_id" class="form-select" required>
            @foreach($users as $u)
            <option value="{{ $u->id }}" {{ old('user_id',$inspeksi->user_id)==$u->id?'selected':'' }}>{{ $u->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Nama Perusahaan <span class="req">*</span></label>
          <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan',$inspeksi->nama_perusahaan) }}" required>
        </div>
      </div>
      <div class="form-grid-3">
        <div class="form-group">
          <label class="form-label">Tanggal <span class="req">*</span></label>
          <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal',$inspeksi->tanggal?->format('Y-m-d')) }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Kategori <span class="req">*</span></label>
          <select name="kategori" class="form-select" required>
            <option value="Inspeksi" {{ old('kategori',$inspeksi->kategori)=='Inspeksi'?'selected':'' }}>Inspeksi</option>
            <option value="Surveilan" {{ old('kategori',$inspeksi->kategori)=='Surveilan'?'selected':'' }}>Surveilan</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Jenis Sertifikat <span class="req">*</span></label>
          <select name="jenis_sertifikat" class="form-select" required>
            @foreach($jenisList as $j)
            <option value="{{ $j }}" {{ old('jenis_sertifikat',$inspeksi->jenis_sertifikat)==$j?'selected':'' }}>{{ $j }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Upload Berkas Baru (opsional)</label>
        @if($inspeksi->berkas_path)
        <div style="font-size:12px; color:var(--text-muted); margin-bottom:6px"><i class="fas fa-file"></i> Berkas saat ini: {{ basename($inspeksi->berkas_path) }}</div>
        @endif
        <input type="file" name="berkas" class="form-control" accept=".pdf,.doc,.docx">
      </div>
      <div style="display:flex; gap:10px">
        <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> Perbarui</button>
        <a href="{{ route('admin.inspeksi.index') }}" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
