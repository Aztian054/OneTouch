@extends('layouts.internal')
@section('title','Edit Survey #' . $skmSurvey->id)
@section('breadcrumb','Survey Kepuasan Masyarakat')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Edit Survey #{{ $skmSurvey->id }}</div>
    <div class="page-subtitle">Edit data survey dari {{ $skmSurvey->nama }}</div>
  </div>
</div>

<form method="POST" action="{{ route('admin.skm.update', $skmSurvey) }}">
  @csrf
  <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:20px;">
    <div class="card">
      <div class="card-header"><span class="card-title">Informasi Responden</span></div>
      <div class="card-body">
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:600;">Nama <span style="color:#ef4444;">*</span></label>
          <input type="text" name="nama" value="{{ old('nama', $skmSurvey->nama) }}" class="form-control" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:6px;" required>
          @error('nama') <div style="color:#ef4444; font-size:12px; margin-top:3px;">{{ $message }}</div> @enderror
        </div>
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:600;">Email</label>
          <input type="email" name="email" value="{{ old('email', $skmSurvey->email) }}" class="form-control" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:6px;">
          @error('email') <div style="color:#ef4444; font-size:12px; margin-top:3px;">{{ $message }}</div> @enderror
        </div>
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:600;">No. Telepon</label>
          <input type="text" name="no_telp" value="{{ old('no_telp', $skmSurvey->no_telp) }}" class="form-control" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:6px;">
          @error('no_telp') <div style="color:#ef4444; font-size:12px; margin-top:3px;">{{ $message }}</div> @enderror
        </div>
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:600;">Jenis Layanan</label>
          <select name="jenis_layanan" class="form-control" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:6px;">
            <option value="">-- Pilih --</option>
            <option value="Sertifikasi Karantina" {{ old('jenis_layanan', $skmSurvey->jenis_layanan) === 'Sertifikasi Karantina' ? 'selected' : '' }}>Sertifikasi Karantina</option>
            <option value="Sertifikasi Mutu" {{ old('jenis_layanan', $skmSurvey->jenis_layanan) === 'Sertifikasi Mutu' ? 'selected' : '' }}>Sertifikasi Mutu</option>
            <option value="Inspeksi Higiene" {{ old('jenis_layanan', $skmSurvey->jenis_layanan) === 'Inspeksi Higiene' ? 'selected' : '' }}>Inspeksi Higiene</option>
            <option value="Lainnya" {{ old('jenis_layanan', $skmSurvey->jenis_layanan) === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
          </select>
          @error('jenis_layanan') <div style="color:#ef4444; font-size:12px; margin-top:3px;">{{ $message }}</div> @enderror
        </div>
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:600;">Status</label>
          <select name="status" class="form-control" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:6px;" required>
            <option value="active" {{ old('status', $skmSurvey->status) === 'active' ? 'selected' : '' }}>Active</option>
            <option value="archived" {{ old('status', $skmSurvey->status) === 'archived' ? 'selected' : '' }}>Archived</option>
          </select>
          @error('status') <div style="color:#ef4444; font-size:12px; margin-top:3px;">{{ $message }}</div> @enderror
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><span class="card-title">Saran & Masukan</span></div>
      <div class="card-body">
        <div style="margin-bottom:15px;">
          <label style="display:block; margin-bottom:5px; font-weight:600;">Saran Masukan</label>
          <textarea name="saran_masukan" rows="8" class="form-control" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:6px; resize:vertical;">{{ old('saran_masukan', $skmSurvey->saran_masukan) }}</textarea>
          @error('saran_masukan') <div style="color:#ef4444; font-size:12px; margin-top:3px;">{{ $message }}</div> @enderror
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><span class="card-title">Rating Penilaian (1-5)</span></div>
    <div class="card-body">
      @php
      $ratings = [
        ['key' => 'q1_kualitas_pelayanan', 'label' => 'Kualitas Pelayanan', 'value' => $skmSurvey->q1_kualitas_pelayanan],
        ['key' => 'q2_kompetensi_petugas', 'label' => 'Kompetensi Petugas', 'value' => $skmSurvey->q2_kompetensi_petugas],
        ['key' => 'q3_kecepatan', 'label' => 'Kecepatan', 'value' => $skmSurvey->q3_kecepatan],
        ['key' => 'q4_kenyamanan', 'label' => 'Kenyamanan', 'value' => $skmSurvey->q4_kenyamanan],
        ['key' => 'q5_kenyamanan_sarpras', 'label' => 'Kenyamanan Sarpras', 'value' => $skmSurvey->q5_kenyamanan_sarpras],
        ['key' => 'q6_fasilitas', 'label' => 'Fasilitas', 'value' => $skmSurvey->q6_fasilitas],
        ['key' => 'q7_penampilan', 'label' => 'Penampilan', 'value' => $skmSurvey->q7_penampilan],
      ];
      @endphp
      @foreach($ratings as $index => $rating)
      <div style="display:grid; grid-template-columns: 1fr 200px; gap:20px; align-items:center; margin-bottom:15px; {{ $index < count($ratings) - 1 ? 'padding-bottom:15px; border-bottom:1px solid #f3f4f6;' : '' }}">
        <div>
          <label style="display:block; margin-bottom:5px; font-weight:600;">{{ $rating['label'] }} <span style="color:#ef4444;">*</span></label>
          @error($rating['key']) <div style="color:#ef4444; font-size:12px;">{{ $message }}</div> @enderror
        </div>
        <div>
          <input type="number" name="{{ $rating['key'] }}" value="{{ old($rating['key'], $rating['value']) }}" class="form-control" style="width:100%; padding:8px 12px; border:1px solid #e5e7eb; border-radius:6px;" min="0" max="5" step="0.1" required>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <div style="display:flex; gap:10px; margin-top:20px;">
    <a href="{{ route('admin.skm.show', $skmSurvey) }}" class="btn btn-outline">
      <i class="fas fa-times" style="margin-right:5px;"></i> Batal
    </a>
    <button type="submit" class="btn btn-primary">
      <i class="fas fa-save" style="margin-right:5px;"></i> Simpan Perubahan
    </button>
  </div>
</form>
@endsection