@extends('layouts.internal')
@section('title','Laporan')
@section('breadcrumb','Laporan')
@section('content')
<div class="page-header">
  <div><div class="page-title">Laporan</div><div class="page-subtitle">Unduh laporan data sertifikat, inspeksi, user, dan data publik</div></div>
</div>
<div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px">
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

  {{-- Laporan User --}}
  <div class="card">
    <div class="card-header"><span class="card-title"><i class="fas fa-users" style="color:var(--gold)"></i> Laporan User</span></div>
    <div class="card-body">
      <form id="formUser" method="GET">
        <div class="form-group">
          <label class="form-label">Role</label>
          <select name="role" class="form-select">
            <option value="">Semua Role</option>
            <option value="admin">Admin</option>
            <option value="officer">Petugas</option>
            <option value="user">User</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Tahun Dibuat</label>
          <input type="number" name="tahun" class="form-control" placeholder="cth: 2024" min="2000" max="2099">
        </div>
        <div style="display:flex; gap:8px">
          <button type="button" onclick="downloadReport('users','pdf')" class="btn btn-primary btn-sm">
            <i class="fas fa-file-pdf"></i> Download PDF
          </button>
          <button type="button" onclick="downloadReport('users','excel')" class="btn btn-gold btn-sm">
            <i class="fas fa-file-excel"></i> Download Excel
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- Laporan SKM Surveys --}}
  <div class="card">
    <div class="card-header"><span class="card-title"><i class="fas fa-star-half-stroke" style="color:var(--gold)"></i> Laporan SKM</span></div>
    <div class="card-body">
      <form id="formSkmSurveys" method="GET">
        <div class="form-group">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="">Semua</option>
            <option value="active">Active</option>
            <option value="archived">Archived</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Jenis Layanan</label>
          <select name="jenis_layanan" class="form-select">
            <option value="">Semua Jenis</option>
            <option value="Sertifikasi Karantina">Sertifikasi Karantina</option>
            <option value="Sertifikasi Mutu">Sertifikasi Mutu</option>
            <option value="Inspeksi Higiene">Inspeksi Higiene</option>
            <option value="Lainnya">Lainnya</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Tahun</label>
          <input type="number" name="tahun" class="form-control" placeholder="cth: 2024" min="2000" max="2099">
        </div>
        <div style="display:flex; gap:8px">
          <button type="button" onclick="downloadReport('skm-surveys','pdf')" class="btn btn-primary btn-sm">
            <i class="fas fa-file-pdf"></i> Download PDF
          </button>
          <button type="button" onclick="downloadReport('skm-surveys','excel')" class="btn btn-gold btn-sm">
            <i class="fas fa-file-excel"></i> Download Excel
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- Laporan Data Ekspor --}}
  <div class="card">
    <div class="card-header"><span class="card-title"><i class="fas fa-chart-line" style="color:var(--gold)"></i> Laporan Data Ekspor</span></div>
    <div class="card-body">
      <form id="formDataEkspor" method="GET">
        <div class="form-group">
          <label class="form-label">Bulan</label>
          <select name="bulan" class="form-select">
            <option value="">Semua Bulan</option>
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
            <option value="4">April</option>
            <option value="5">Mei</option>
            <option value="6">Juni</option>
            <option value="7">Juli</option>
            <option value="8">Agustus</option>
            <option value="9">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Tahun</label>
          <input type="number" name="tahun" class="form-control" placeholder="cth: 2024" min="2000" max="2099">
        </div>
        <div style="display:flex; gap:8px">
          <button type="button" onclick="downloadReport('data-ekspor','pdf')" class="btn btn-primary btn-sm">
            <i class="fas fa-file-pdf"></i> Download PDF
          </button>
          <button type="button" onclick="downloadReport('data-ekspor','excel')" class="btn btn-gold btn-sm">
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
  const formMap = {
    sertifikat: 'formSertifikat',
    inspeksi: 'formInspeksi',
    users: 'formUser',
    'skm-surveys': 'formSkmSurveys',
    'data-ekspor': 'formDataEkspor'
  };
  const form = document.getElementById(formMap[type]);
  const params = new URLSearchParams(new FormData(form)).toString();
  let url = '';
  const routes = {
    sertifikat: {
      pdf:   '{{ route("admin.laporan.sertifikat.pdf") }}',
      excel: '{{ route("admin.laporan.sertifikat.excel") }}'
    },
    inspeksi: {
      pdf:   '{{ route("admin.laporan.inspeksi.pdf") }}',
      excel: '{{ route("admin.laporan.inspeksi.excel") }}'
    },
    users: {
      pdf:   '{{ route("admin.laporan.users.pdf") }}',
      excel: '{{ route("admin.laporan.users.excel") }}'
    },
    'skm-surveys': {
      pdf:   '{{ route("admin.laporan.skm-surveys.pdf") }}',
      excel: '{{ route("admin.laporan.skm-surveys.excel") }}'
    },
    'data-ekspor': {
      pdf:   '{{ route("admin.laporan.data-ekspor.pdf") }}',
      excel: '{{ route("admin.laporan.data-ekspor.excel") }}'
    }
  };
  url = routes[type][format];
  window.location.href = url + (params ? '?' + params : '');
}
</script>
@endpush
@endsection
