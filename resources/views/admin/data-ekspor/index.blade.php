@extends('layouts.internal')
@section('title', 'Data Ekspor')
@section('breadcrumb', 'Data Ekspor')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Data Ekspor Hasil Kelautan dan Perikanan</div>
    <div class="page-subtitle">Kelola data statistik ekspor</div>
  </div>
  <div style="display:flex; gap:10px;">
    @if($dataEkspors->count())
    <button type="button" class="btn btn-danger" onclick="showDeleteAllModal()">
      <i class="fas fa-trash-alt"></i> Hapus Semua Data
    </button>
    @endif
    <a href="{{ route('admin.data-ekspor.create') }}" class="btn btn-primary">
      <i class="fas fa-plus"></i> Tambah Data
    </a>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">Daftar Data Ekspor</div>
  </div>
  <div class="card-body">
    @if($dataEkspors->count())
    <div class="table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Frekuensi</th>
            <th>Volume (Ton)</th>
            <th>Nilai (USD)</th>
            <th>Komoditas</th>
            <th>Negara Tujuan</th>
            <th style="text-align:right;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($dataEkspors as $ekspor)
          <tr>
            <td>{{ $ekspor->nama_bulan }}</td>
            <td>{{ $ekspor->tahun }}</td>
            <td><strong>{{ number_format($ekspor->frekuensi) }}</strong></td>
            <td>{{ number_format($ekspor->volume, 2) }}</td>
            <td>{{ number_format($ekspor->nilai, 2) }}</td>
            <td>{{ $ekspor->komoditas ?? '-' }}</td>
            <td>{{ $ekspor->negara_tujuan ?? '-' }}</td>
            <td style="text-align:right;">
              <a href="{{ route('admin.data-ekspor.edit', $ekspor) }}" class="btn btn-sm btn-primary" style="display:inline-flex; align-items:center; gap:5px;">
                <i class="fas fa-pen"></i> Edit
              </a>
              <form method="POST" action="{{ route('admin.data-ekspor.destroy', $ekspor) }}" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" style="display:inline-flex; align-items:center; gap:5px;">
                  <i class="fas fa-trash"></i> Hapus
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @else
    <div class="empty-state">
      <i class="fas fa-chart-line"></i>
      <p>Belum ada data ekspor yang tersimpan.</p>
    </div>
    @endif
  </div>
</div>

<!-- Modal Delete All -->
<div id="deleteAllModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:1000; align-items:center; justify-content:center;">
  <div style="background:var(--surface); border-radius:12px; padding:28px; max-width:420px; width:90%; box-shadow:0 20px 50px rgba(0,0,0,.3);">
    <div style="text-align:center; margin-bottom:24px;">
      <i class="fas fa-exclamation-triangle" style="font-size:48px; color:var(--danger);"></i>
    </div>
    <h3 style="text-align:center; margin:0 0 12px 0; color:var(--text);">Hapus Semua Data?</h3>
    <p style="text-align:center; color:var(--text-muted); margin:0 0 24px 0; line-height:1.6;">
      Tindakan ini akan <strong>menghapus semua data ekspor</strong> ({{ $dataEkspors->count() }} record).<br>
      Tindakan ini <strong>tidak dapat dibatalkan</strong>.<br>
      <br>
      Masukkan password Anda untuk konfirmasi.
    </p>
    <form method="POST" action="{{ route('admin.data-ekspor.destroy-all') }}">
      @csrf
      @method('DELETE')
      <div style="margin-bottom:20px;">
        <label style="display:block; margin-bottom:8px; font-weight:600; color:var(--text);">Password Admin</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required autofocus>
        @error('password')
        <div style="color:var(--danger); font-size:13px; margin-top:6px;">{{ $message }}</div>
        @enderror
      </div>
      <div style="display:flex; gap:10px;">
        <button type="button" class="btn btn-outline" style="flex:1;" onclick="hideDeleteAllModal()">Batal</button>
        <button type="submit" class="btn btn-danger" style="flex:1;">Ya, Hapus Semua</button>
      </div>
    </form>
  </div>
</div>

<script>
function showDeleteAllModal() {
  document.getElementById('deleteAllModal').style.display = 'flex';
}

function hideDeleteAllModal() {
  document.getElementById('deleteAllModal').style.display = 'none';
}

// Close modal on backdrop click
document.getElementById('deleteAllModal').addEventListener('click', function(e) {
  if (e.target === this) {
    hideDeleteAllModal();
  }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    hideDeleteAllModal();
  }
});
</script>
@endsection
