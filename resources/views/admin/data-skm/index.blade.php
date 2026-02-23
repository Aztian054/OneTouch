@extends('layouts.internal')
@section('title','Data SKM')
@section('breadcrumb','Data SKM')

@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Data SKM</div>
    <div class="page-subtitle">Kelola data Target dan Realisasi Indeks Kepuasan Masyarakat per tahun</div>
  </div>
  <a href="{{ route('admin.data-skm.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Tambah Data
  </a>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">Tabel Data SKM</div>
  </div>
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>Tahun</th>
          <th>Target IKM</th>
          <th>Realisasi IKM</th>
          <th>Capaian</th>
          <th style="text-align:right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($skmData as $skm)
        @php
          $pct = $skm->target > 0 ? round($skm->realisasi / $skm->target * 100, 1) : 0;
        @endphp
        <tr>
          <td><strong>{{ $skm->tahun }}</strong></td>
          <td>{{ number_format($skm->target, 2) }}</td>
          <td><strong style="color:{{ $skm->realisasi >= $skm->target ? '#22c55e' : '#ef4444' }}">{{ number_format($skm->realisasi, 2) }}</strong></td>
          <td>
            <span class="badge badge-{{ $pct >= 100 ? 'aktif' : 'warning' }}">
              {{ $pct }}%
            </span>
          </td>
          <td style="text-align:right;">
            <div style="display:flex; gap:5px; justify-content:flex-end;">
              <a href="{{ route('admin.data-skm.edit', $skm) }}" class="btn-icon btn-warning" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              <form action="{{ route('admin.data-skm.destroy', $skm) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-icon btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus data SKM tahun {{ $skm->tahun }}?')">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center; color:var(--text-muted); padding:40px;">Belum ada data SKM</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection