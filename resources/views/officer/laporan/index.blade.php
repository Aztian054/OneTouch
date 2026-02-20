@extends('layouts.internal')
@section('title','Laporan')
@section('breadcrumb','Laporan')
@section('content')
<div class="page-header">
  <div><div class="page-title">Laporan</div><div class="page-subtitle">Unduh laporan data sertifikat dan inspeksi lingkup penugasan Anda</div></div>
</div>
<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px">
  {{-- Laporan Sertifikat --}}
  <div class="card">
    <div class="card-header"><span class="card-title"><i class="fas fa-certificate" style="color:var(--gold)"></i> Laporan Sertifikat</span></div>
    <div class="card-body">
      <form id="formSertifikat" method="GET">
        <div class="form-group">
          <label class="form-label">Jenis Sertifikat</label>
          <select name="jenis" class="form-select">
            <option value="">Semua Jenis</option>
            @foreach(\App\Models\Sertifikat::getJenisList() as $j)
            <option value="{{ $j }}">{{ $j }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-grid-2">
          <div class="form-group">
            <label class="form-label">Status Masa</label>
            <select name="status_masa" class="form-select">
              <option value="">Semua</option>
              <option value="aktif">Aktif</option>
              <option value="warning">Warning</option>
              <option value="expired">Expired</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Grade</label>
            <select name="grade" class="form-select">
              <option value="">Semua</option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Tahun Terbit</label>
          <input type="number" name="tahun" class="form-control" placeholder="cth: 2024" min="2000" max="2099">
        </div>
        <div style="display:flex; gap:8px">
          <button type="button" onclick="downloadReport('sertifikat','pdf')" class="btn btn-primary btn-sm">
            <i class="fas fa-file-pdf"></i> Download PDF
          </button>
          <button type="button" onclick="downloadReport('sertifikat','excel')" class="btn btn-gold btn-sm">
            <i class="fas fa-file-excel"></i> Download Excel
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- Laporan Inspeksi --}}
  <div class="card">
    <div class="card-header"><span class="card-title"><i class="fas fa-clipboard-check" style="color:var(--gold)"></i> Laporan Inspeksi</span></div>
    <div class="card-body">
      <form id="formInspeksi" method="GET">
        <div class="form-group">
          <label class="form-label">Kategori</label>
          <select name="kategori" class="form-select">
            <option value="">Semua</option>
            <option value="Inspeksi">Inspeksi</option>
            <option value="Surveilan">Surveilan</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Jenis Sertifikat</label>
          <select name="jenis" class="form-select">
            <option value="">Semua Jenis</option>
            @foreach(\App\Models\Sertifikat::getJenisList() as $j)
            <option value="{{ $j }}">{{ $j }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Tahun</label>
          <input type="number" name="tahun" class="form-control" placeholder="cth: 2024" min="2000" max="2099">
        </div>
        <div style="display:flex; gap:8px; margin-top:8px">
          <button type="button" onclick="downloadReport('inspeksi','pdf')" class="btn btn-primary btn-sm">
            <i class="fas fa-file-pdf"></i> Download PDF
          </button>
          <button type="button" onclick="downloadReport('inspeksi','excel')" class="btn btn-gold btn-sm">
            <i class="fas fa-file-excel"></i> Download Excel
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@push('scripts')
<script>
function downloadReport(type, format) {
  const form = document.getElementById('form' + type.charAt(0).toUpperCase() + type.slice(1));
  const params = new URLSearchParams(new FormData(form)).toString();
  const routes = {
    sertifikat: {
      pdf:   '{{ route("officer.laporan.sertifikat.pdf") }}',
      excel: '{{ route("officer.laporan.sertifikat.excel") }}'
    },
    inspeksi: {
      pdf:   '{{ route("officer.laporan.inspeksi.pdf") }}',
      excel: '{{ route("officer.laporan.inspeksi.excel") }}'
    }
  };
  const url = routes[type][format];
  window.location.href = url + (params ? '?' + params : '');
}
</script>
@endpush
@endsection
