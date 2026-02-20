@extends('layouts.internal')
@section('title','Sertifikat')
@section('breadcrumb','Sertifikat')
@section('content')
<div class="page-header">
  <div><div class="page-title">Data Sertifikat</div><div class="page-subtitle">Kelola sertifikat lingkup penugasan Anda</div></div>
  <div class="page-actions">
    <a href="{{ route('officer.sertifikat.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
  </div>
</div>

{{-- Filter --}}
<div class="card" style="margin-bottom:16px">
  <div class="card-body" style="padding:12px 16px">
    <form method="GET" style="display:flex; gap:10px; flex-wrap:wrap; align-items:flex-end">
      <div class="form-group" style="margin:0; flex:1; min-width:160px">
        <label class="form-label" style="font-size:11px">Cari</label>
        <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="No. sertifikat / pemilik…">
      </div>
      <div class="form-group" style="margin:0; min-width:140px">
        <label class="form-label" style="font-size:11px">Jenis</label>
        <select name="jenis" class="form-select form-select-sm">
          <option value="">Semua Jenis</option>
          @foreach(\App\Models\Sertifikat::getJenisList() as $j)
          <option value="{{ $j }}" {{ request('jenis')==$j?'selected':'' }}>{{ $j }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group" style="margin:0; min-width:120px">
        <label class="form-label" style="font-size:11px">Status</label>
        <select name="status_masa" class="form-select form-select-sm">
          <option value="">Semua Status</option>
          <option value="aktif" {{ request('status_masa')=='aktif'?'selected':'' }}>Aktif</option>
          <option value="warning" {{ request('status_masa')=='warning'?'selected':'' }}>Warning</option>
          <option value="expired" {{ request('status_masa')=='expired'?'selected':'' }}>Expired</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
      <a href="{{ route('officer.sertifikat.index') }}" class="btn btn-sm" style="background:var(--border); color:var(--text)"><i class="fas fa-times"></i></a>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body" style="padding:0">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>No. Sertifikat</th>
          <th>Nama Pemilik</th>
          <th>Jenis</th>
          <th>Grade</th>
          <th>Tgl Terbit</th>
          <th>Tgl Kadaluwarsa</th>
          <th>Status</th>
          <th>Berkas</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sertifikats as $s)
        <tr>
          <td>{{ $sertifikats->firstItem() + $loop->index }}</td>
          <td>{{ $s->nomor_sertifikat }}</td>
          <td>{{ $s->nama_pemilik }}</td>
          <td>{{ $s->jenis_sertifikat }}</td>
          <td><span class="badge badge-primary">{{ $s->grade }}</span></td>
          <td>{{ $s->tanggal_terbit?->format('d/m/Y') }}</td>
          <td>{{ $s->tanggal_kadaluwarsa?->format('d/m/Y') }}</td>
          <td>
            <span class="badge badge-{{ $s->status_masa==='aktif'?'success':($s->status_masa==='warning'?'warning':'danger') }}">{{ ucfirst($s->status_masa) }}</span>
          </td>
          <td>
            @if($s->berkas_path)
              <span class="badge" style="background:#dcfce7; color:#166534"><i class="fas fa-paperclip"></i> Ada</span>
            @else
              <span style="color:var(--text-muted); font-size:12px">-</span>
            @endif
          </td>
          <td>
            <div style="display:flex; gap:4px">
              <a href="{{ route('officer.sertifikat.show',$s->id) }}" class="btn btn-icon btn-sm" title="Detail"><i class="fas fa-eye"></i></a>
              <a href="{{ route('officer.sertifikat.edit',$s->id) }}" class="btn btn-icon btn-sm" title="Edit"><i class="fas fa-pencil-alt"></i></a>
              <form method="POST" action="{{ route('officer.sertifikat.destroy',$s->id) }}" onsubmit="return confirm('Hapus sertifikat ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-icon btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="10" style="text-align:center; color:var(--text-muted); padding:32px">Tidak ada data sertifikat.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($sertifikats->hasPages())
  <div class="card-footer">{{ $sertifikats->withQueryString()->links('vendor.pagination.custom') }}</div>
  @endif
</div>
@endsection
