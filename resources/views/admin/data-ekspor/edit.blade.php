@extends('layouts.internal')
@section('title', 'Edit Data Ekspor')
@section('breadcrumb', 'Data Ekspor')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Edit Data Ekspor</div>
    <div class="page-subtitle">Ubah data statistik ekspor: {{ $dataEkspor->nama_bulan }} {{ $dataEkspor->tahun }}</div>
  </div>
</div>

<form method="POST" action="{{ route('admin.data-ekspor.update', $dataEkspor) }}">
  @csrf
  @method('PUT')

  <div class="card" style="margin-bottom:20px;">
    <div class="card-header"><span class="card-title">Informasi Periode</span></div>
    <div class="card-body">
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Bulan <span class="req">*</span></label>
          <select name="bulan" class="form-select" required>
            @for($i = 1; $i <= 12; $i++)
            <option value="{{ $i }}" {{ old('bulan', $dataEkspor->bulan) == $i ? 'selected' : '' }}>
              {{ App\Models\DataEkspor::getNamaBulan($i) }}
            </option>
            @endfor
          </select>
          @error('bulan') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
          <label class="form-label">Tahun <span class="req">*</span></label>
          <input type="number" name="tahun" value="{{ old('tahun', $dataEkspor->tahun) }}" class="form-control" min="2000" max="2100" required>
          @error('tahun') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
      </div>
    </div>
  </div>

  <div class="card" style="margin-bottom:20px;">
    <div class="card-header"><span class="card-title">Data Statistik</span></div>
    <div class="card-body">
      <div class="form-grid-3">
        <div class="form-group">
          <label class="form-label">Frekuensi <span class="req">*</span></label>
          <input type="number" name="frekuensi" value="{{ old('frekuensi', $dataEkspor->frekuensi) }}" class="form-control" min="0" required>
          <div class="form-hint">Jumlah pengiriman/kapal</div>
          @error('frekuensi') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
          <label class="form-label">Volume (Ton) <span class="req">*</span></label>
          <input type="number" name="volume" value="{{ old('volume', $dataEkspor->volume) }}" class="form-control" min="0" step="0.01" required>
          @error('volume') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
          <label class="form-label">Nilai (USD) <span class="req">*</span></label>
          <input type="number" name="nilai" value="{{ old('nilai', $dataEkspor->nilai) }}" class="form-control" min="0" step="0.01" required>
          @error('nilai') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><span class="card-title">Informasi Detail</span></div>
    <div class="card-body">
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Komoditas</label>
          <input type="text" name="komoditas" value="{{ old('komoditas', $dataEkspor->komoditas) }}" class="form-control" placeholder="Contoh: Tuna, Udang, dll">
          @error('komoditas') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
          <label class="form-label">Negara Tujuan</label>
          <input type="text" name="negara_tujuan" value="{{ old('negara_tujuan', $dataEkspor->negara_tujuan) }}" class="form-control" placeholder="Contoh: Jepang, Amerika Serikat, dll">
          @error('negara_tujuan') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Unit Pelaksana Teknis</label>
          <input type="text" name="unit_pelaksana" value="{{ old('unit_pelaksana', $dataEkspor->unit_pelaksana) }}" class="form-control" placeholder="Contoh: UPT Lampung, dll">
          @error('unit_pelaksana') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
        <div class="form-group">
          <label class="form-label">Eksportir</label>
          <input type="text" name="eksportir" value="{{ old('eksportir', $dataEkspor->eksportir) }}" class="form-control" placeholder="Nama perusahaan eksportir">
          @error('eksportir') <div class="form-error"><i class="fas fa-circle-xmark"></i> {{ $message }}</div> @enderror
        </div>
      </div>
    </div>
  </div>

  <div style="display:flex; gap:10px; margin-top:20px;">
    <a href="{{ route('admin.data-ekspor.index') }}" class="btn btn-outline">
      <i class="fas fa-times"></i> Batal
    </a>
    <button type="submit" class="btn btn-primary">
      <i class="fas fa-save"></i> Simpan Perubahan
    </button>
  </div>
</form>
@endsection