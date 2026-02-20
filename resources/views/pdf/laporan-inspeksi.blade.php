<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1e293b; }
  .header { border-bottom: 3px solid #0f172a; padding-bottom: 10px; margin-bottom: 14px; }
  .header h1 { font-size: 13px; font-weight: bold; color: #0f172a; }
  .header p  { font-size: 9px; color: #64748b; margin-top: 2px; }
  .meta { display: flex; justify-content: space-between; margin-bottom: 12px; }
  .meta span { font-size: 9px; color: #64748b; }
  table { width: 100%; border-collapse: collapse; }
  th { background-color: #0f172a; color: #fff; padding: 5px 6px; text-align: left; font-size: 9px; }
  td { padding: 5px 6px; border-bottom: 1px solid #e2e8f0; font-size: 9px; }
  tr:nth-child(even) td { background-color: #f8fafc; }
  .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 8px; font-weight: bold; }
  .badge-terkirim  { background: #dcfce7; color: #166534; }
  .badge-tidak-ada { background: #fee2e2; color: #991b1b; }
  .footer { margin-top: 14px; font-size: 8px; color: #94a3b8; text-align: center; }
</style>
</head>
<body>

<div class="header">
  <h1>LAPORAN DATA INSPEKSI</h1>
  <p>Balai PPMHKP Lampung — Kementerian Kelautan dan Perikanan</p>
  <p>ONE TOUCH System</p>
</div>

<div class="meta">
  <span>Tanggal Cetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</span>
  <span>Total Data: {{ $inspeksis->count() }}</span>
</div>

<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Perusahaan</th>
      <th>Tanggal</th>
      <th>Kategori</th>
      <th>Jenis Sertifikat</th>
      <th>Status Berkas</th>
      <th>Petugas</th>
    </tr>
  </thead>
  <tbody>
    @forelse($inspeksis as $i => $ins)
    <tr>
      <td>{{ $i + 1 }}</td>
      <td>{{ $ins->nama_perusahaan }}</td>
      <td>{{ $ins->tanggal?->format('d/m/Y') }}</td>
      <td>{{ $ins->kategori }}</td>
      <td>{{ $ins->jenis_sertifikat }}</td>
      <td>
        @if($ins->status_berkas === 'Terkirim')
          <span class="badge badge-terkirim">Terkirim</span>
        @else
          <span class="badge badge-tidak-ada">Tidak Ada</span>
        @endif
      </td>
      <td>{{ $ins->creator?->name ?? '-' }}</td>
    </tr>
    @empty
    <tr><td colspan="7" style="text-align:center;color:#94a3b8;">Tidak ada data</td></tr>
    @endforelse
  </tbody>
</table>

<div class="footer">
  Dokumen ini digenerate otomatis oleh sistem ONE TOUCH — Balai PPMHKP Lampung
</div>

</body>
</html>
