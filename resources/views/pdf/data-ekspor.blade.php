<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Ekspor - ONE TOUCH</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #1e293b;
            background: #fff;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            border-bottom: 2px solid #d4af37;
            margin-bottom: 20px;
        }
        .header-left { display: flex; align-items: center; gap: 15px; }
        .header-logo { width: 50px; height: 50px; }
        .header-title h1 {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }
        .header-title p {
            font-size: 11px;
            color: #64748b;
            margin: 2px 0 0;
        }
        .header-meta {
            text-align: right;
            font-size: 10px;
            color: #64748b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        thead {
            background: #f8fafc;
        }
        th {
            padding: 8px 10px;
            font-size: 9px;
            font-weight: 600;
            text-align: left;
            color: #475569;
            border-bottom: 2px solid #e2e8f0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
            color: #334155;
        }
        tr:last-child td { border-bottom: none; }
        tr:nth-child(even) { background: #f8fafc; }
        .number { text-align: right; }
        .footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            font-size: 10px;
            color: #64748b;
            text-align: center;
        }
        .summary {
            margin-top: 20px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        .summary-item {
            text-align: center;
        }
        .summary-value {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
        }
        .summary-label {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }
        @media print {
            body { font-size: 10px; }
            .summary-grid { grid-template-columns: repeat(2, 1fr); }
            th, td { padding: 6px 8px; font-size: 9px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <img src="{{ public_path('assets/Portal-LogoKKPRound-Warna.png') }}" class="header-logo" alt="KKP">
            <div class="header-title">
                <h1>Laporan Data Ekspor</h1>
                <p>Sistem Manajemen Data Ekspor - Balai PPMHKP Lampung</p>
            </div>
        </div>
        <div class="header-meta">
            <div><strong>Tanggal:</strong> {{ now()->format('d/m/Y') }}</div>
            <div><strong>Total Data:</strong> {{ $dataEkspor->count() }} Ekspor</div>
        </div>
    </div>

    <div class="summary">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-value">{{ number_format($dataEkspor->sum('frekuensi'), 0, ',', '.') }}</div>
                <div class="summary-label">Total Frekuensi (Kali)</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ number_format($dataEkspor->sum('volume'), 2, ',', '.') }}</div>
                <div class="summary-label">Total Volume (Ton)</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">$ {{ number_format($dataEkspor->sum('nilai'), 2, ',', '.') }}</div>
                <div class="summary-label">Total Nilai (US$)</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Frekuensi</th>
                <th>Volume (Ton)</th>
                <th>Nilai (US$)</th>
                <th>Komoditas</th>
                <th>Negara Tujuan</th>
                <th>Unit Pelaksana</th>
                <th>Eksportir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataEkspor as $i => $data)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $data->nama_bulan }}</td>
                <td>{{ $data->tahun }}</td>
                <td class="number">{{ number_format($data->frekuensi, 0, ',', '.') }}</td>
                <td class="number">{{ number_format($data->volume, 2, ',', '.') }}</td>
                <td class="number">$ {{ number_format($data->nilai, 2, ',', '.') }}</td>
                <td>{{ $data->komoditas ?? '-' }}</td>
                <td>{{ $data->negara_tujuan ?? '-' }}</td>
                <td>{{ $data->unit_pelaksana ?? '-' }}</td>
                <td>{{ $data->eksportir ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center; padding: 30px; color: #64748b;">
                    Tidak ada data ekspor
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dicetak otomatis oleh sistem ONE TOUCH pada {{ now()->format('d/m/Y H:i') }}</p>
        <p>© {{ date('Y') }} Balai PPMHKP Lampung - Kementerian Kelautan dan Perikanan</p>
    </div>
</body>
</html>