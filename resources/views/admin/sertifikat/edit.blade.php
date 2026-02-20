@extends('layouts.internal')
@section('title','Edit Sertifikat')
@section('breadcrumb','Edit Sertifikat')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Edit Sertifikat</div>
    <div class="page-subtitle">{{ $sertifikat->nomor_sertifikat }}</div>
  </div>
  <a href="{{ route('admin.sertifikat.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card" style="max-width:800px">
  <div class="card-header"><span class="card-title">Edit Data Sertifikat</span></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.sertifikat.update', $sertifikat) }}" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Pemilik <span class="req">*</span></label>
          <select name="user_id" class="form-select" required>
            @foreach($users as $u)
            <option value="{{ $u->id }}" {{ (old('user_id',$sertifikat->user_id)==$u->id)?'selected':'' }}>
              {{ $u->name }} {{ $u->company_name ? "({$u->company_name})" : '' }}
            </option>
            @endforeach
          </select>
          @error('user_id')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Nama Pemilik <span class="req">*</span></label>
          <input type="text" name="nama_pemilik" class="form-control" value="{{ old('nama_pemilik',$sertifikat->nama_pemilik) }}" required>
          @error('nama_pemilik')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Nomor Sertifikat <span class="req">*</span></label>
          <input type="text" name="nomor_sertifikat" class="form-control" value="{{ old('nomor_sertifikat',$sertifikat->nomor_sertifikat) }}" required>
          @error('nomor_sertifikat')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Jenis Sertifikat <span class="req">*</span></label>
          <select name="jenis_sertifikat" class="form-select" required>
            @foreach($jenisList as $j)
            <option value="{{ $j }}" {{ old('jenis_sertifikat',$sertifikat->jenis_sertifikat)==$j?'selected':'' }}>{{ $j }}</option>
            @endforeach
          </select>
          @error('jenis_sertifikat')<div class="form-error">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Ruang Lingkup <span class="req">*</span></label>
        <textarea name="ruang_lingkup" class="form-control" required>{{ old('ruang_lingkup',$sertifikat->ruang_lingkup) }}</textarea>
        @error('ruang_lingkup')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div class="form-grid-3">
        <div class="form-group">
          <label class="form-label">Grade <span class="req">*</span></label>
          <select name="grade" class="form-select" required>
            @foreach(['A','B','C'] as $g)
            <option value="{{ $g }}" {{ old('grade',$sertifikat->grade)==$g?'selected':'' }}>{{ $g }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Tanggal Terbit <span class="req">*</span></label>
          <input type="date" name="tanggal_terbit" class="form-control" value="{{ old('tanggal_terbit',$sertifikat->tanggal_terbit?->format('Y-m-d')) }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Tanggal Kadaluwarsa <span class="req">*</span></label>
          <input type="date" name="tanggal_kadaluwarsa" class="form-control" value="{{ old('tanggal_kadaluwarsa',$sertifikat->tanggal_kadaluwarsa?->format('Y-m-d')) }}" required>
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Status Proses <span class="req">*</span></label>
        <select name="status_proses" class="form-select" style="max-width:240px" required>
          @foreach(['Pending','Process','Completed'] as $sp)
          <option value="{{ $sp }}" {{ old('status_proses',$sertifikat->status_proses)==$sp?'selected':'' }}>{{ $sp }}</option>
          @endforeach
        </select>
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
      <div style="display:flex; gap:10px; padding-top:8px">
        <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> Perbarui</button>
        <a href="{{ route('admin.sertifikat.index') }}" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
