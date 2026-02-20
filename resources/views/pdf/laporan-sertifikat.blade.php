<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1e293b; }
  .header { display: flex; align-items: center; border-bottom: 3px solid #0f172a; padding-bottom: 10px; margin-bottom: 14px; }
  .header-text { flex: 1; }
  .header-text h1 { font-size: 13px; font-weight: bold; color: #0f172a; }
  .header-text p { font-size: 9px; color: #64748b; margin-top: 2px; }
  .meta { display: flex; justify-content: space-between; margin-bottom: 12px; }
  .meta span { font-size: 9px; color: #64748b; }
  table { width: 100%; border-collapse: collapse; }
  th { background-color: #0f172a; color: #fff; padding: 5px 6px; text-align: left; font-size: 9px; }
  td { padding: 5px 6px; border-bottom: 1px solid #e2e8f0; font-size: 9px; }
  tr:nth-child(even) td { background-color: #f8fafc; }
  .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 8px; font-weight: bold; }
  .badge-aktif    { background: #dcfce7; color: #166534; }
  .badge-warning  { background: #fef9c3; color: #854d0e; }
  .badge-expired  { background: #fee2e2; color: #991b1b; }
  .badge-grade    { background: #e0f2fe; color: #0369a1; }
  .footer { margin-top: 14px; font-size: 8px; color: #94a3b8; text-align: center; }
</style>
</head>
<body>

<div class="header">
  <div class="header-text">
    <h1>LAPORAN DATA SERTIFIKAT</h1>
    <p>Balai PPMHKP Lampung — Kementerian Kelautan dan Perikanan</p>
    <p>ONE TOUCH System</p>
  </div>
</div>

<div class="meta">
  <span>Tanggal Cetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</span>
  <span>Total Data: {{ $sertifikats->count() }}</span>
</div>

<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Pemilik</th>
      <th>Nomor Sertifikat</th>
      <th>Jenis</th>
      <th>Grade</th>
      <th>Tgl Terbit</th>
      <th>Tgl Kadaluwarsa</th>
      <th>Status</th>
      <th>Proses</th>
    </tr>
  </thead>
  <tbody>
    @forelse($sertifikats as $i => $s)
    <tr>
      <td>{{ $i + 1 }}</td>
      <td>{{ $s->nama_pemilik }}</td>
      <td>{{ $s->nomor_sertifikat }}</td>
      <td>{{ $s->jenis_sertifikat }}</td>
      <td><span class="badge badge-grade">{{ $s->grade }}</span></td>
      <td>{{ $s->tanggal_terbit?->format('d/m/Y') }}</td>
      <td>{{ $s->tanggal_kadaluwarsa?->format('d/m/Y') }}</td>
      <td>
        <span class="badge badge-{{ $s->status_masa }}">{{ strtoupper($s->status_masa) }}</span>
      </td>
      <td>{{ $s->status_proses }}</td>
    </tr>
    @empty
    <tr><td colspan="9" style="text-align:center;color:#94a3b8;">Tidak ada data</td></tr>
    @endforelse
  </tbody>
</table>

<div class="footer">
  Dokumen ini digenerate otomatis oleh sistem ONE TOUCH — Balai PPMHKP Lampung
</div>

</body>
</html>
