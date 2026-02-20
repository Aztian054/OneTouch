@extends('layouts.internal')
@section('title','Edit Sertifikat')
@section('breadcrumb','Sertifikat / Edit')
@section('content')
<div class="page-header">
  <div><div class="page-title">Edit Sertifikat</div></div>
  <div class="page-actions"><a href="{{ route('officer.sertifikat.index') }}" class="btn btn-sm" style="background:var(--border); color:var(--text)"><i class="fas fa-arrow-left"></i> Kembali</a></div>
</div>
<div class="card" style="max-width:720px">
  <div class="card-body">
    @if($errors->any())
    <div class="alert alert-danger"><ul style="margin:0; padding-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    <form method="POST" action="{{ route('officer.sertifikat.update',$sertifikat->id) }}" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="form-group">
        <label class="form-label">User Pemilik <span style="color:#ef4444">*</span></label>
        <select name="user_id" class="form-select" required>
          <option value="">-- Pilih Pengguna --</option>
          @foreach($assignedUsers as $u)
          <option value="{{ $u->id }}" {{ old('user_id',$sertifikat->user_id)==$u->id?'selected':'' }}>{{ $u->name }} ({{ $u->username }})</option>
          @endforeach
        </select>
        @error('user_id')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Nomor Sertifikat <span style="color:#ef4444">*</span></label>
          <input type="text" name="nomor_sertifikat" class="form-control" value="{{ old('nomor_sertifikat',$sertifikat->nomor_sertifikat) }}" required>
          @error('nomor_sertifikat')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Nama Pemilik <span style="color:#ef4444">*</span></label>
          <input type="text" name="nama_pemilik" class="form-control" value="{{ old('nama_pemilik',$sertifikat->nama_pemilik) }}" required>
          @error('nama_pemilik')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Ruang Lingkup <span style="color:#ef4444">*</span></label>
        <textarea name="ruang_lingkup" class="form-control" rows="2" required>{{ old('ruang_lingkup',$sertifikat->ruang_lingkup) }}</textarea>
        @error('ruang_lingkup')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Jenis Sertifikat <span style="color:#ef4444">*</span></label>
          <select name="jenis_sertifikat" class="form-select" required>
            <option value="">-- Pilih --</option>
            @foreach($jenisList as $j)
            <option value="{{ $j }}" {{ old('jenis_sertifikat',$sertifikat->jenis_sertifikat)==$j?'selected':'' }}>{{ $j }}</option>
            @endforeach
          </select>
          @error('jenis_sertifikat')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Grade <span style="color:#ef4444">*</span></label>
          <select name="grade" class="form-select" required>
            <option value="">-- Pilih --</option>
            @foreach(['A','B','C'] as $g)
            <option value="{{ $g }}" {{ old('grade',$sertifikat->grade)==$g?'selected':'' }}>{{ $g }}</option>
            @endforeach
          </select>
          @error('grade')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Tanggal Terbit <span style="color:#ef4444">*</span></label>
          <input type="date" name="tanggal_terbit" class="form-control" value="{{ old('tanggal_terbit',$sertifikat->tanggal_terbit?->format('Y-m-d')) }}" required>
          @error('tanggal_terbit')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Tanggal Kadaluwarsa <span style="color:#ef4444">*</span></label>
          <input type="date" name="tanggal_kadaluwarsa" class="form-control" value="{{ old('tanggal_kadaluwarsa',$sertifikat->tanggal_kadaluwarsa?->format('Y-m-d')) }}" required>
          @error('tanggal_kadaluwarsa')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Status Proses <span style="color:#ef4444">*</span></label>
        <select name="status_proses" class="form-select" required style="max-width:240px">
          @foreach(['Pending','Process','Completed'] as $sp)
          <option value="{{ $sp }}" {{ old('status_proses',$sertifikat->status_proses)==$sp?'selected':'' }}>{{ $sp }}</option>
          @endforeach
        </select>
        @error('status_proses')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Upload Berkas <span style="font-size:11px; color:var(--text-muted)">(PDF/DOC/DOCX, maks 5MB)</span></label>
        @if($sertifikat->berkas_path)
          <div style="margin-bottom:8px; padding:8px 12px; background:var(--bg-secondary); border-radius:6px; display:flex; align-items:center; gap:10px; font-size:13px">
            <i class="fas fa-file-alt" style="color:var(--navy)"></i>
            <a href="{{ Storage::url($sertifikat->berkas_path) }}" target="_blank" style="color:var(--navy)">Lihat berkas saat ini</a>
            <span style="color:var(--text-muted)">— Upload baru untuk mengganti</span>
          </div>
        @endif
        <input type="file" name="berkas" class="form-control" accept=".pdf,.doc,.docx">
        @error('berkas')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div style="display:flex; gap:8px; justify-content:flex-end; padding-top:8px">
        <a href="{{ route('officer.sertifikat.index') }}" class="btn btn-sm" style="background:var(--border); color:var(--text)">Batal</a>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Update</button>
      </div>
    </form>
  </div>
</div>
@endsection
