<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Survey Kepuasan Masyarakat</title>
    <style>
        @media print {
            @page { margin: 20mm; }
            body { font-size: 11px; }
        }
        body { font-family: Arial, sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #d4af37; padding-bottom: 15px; }
        .header img { height: 60px; margin-bottom: 10px; }
        .header h1 { font-size: 18px; margin: 5px 0; color: #0f172a; }
        .header p { font-size: 12px; margin: 0; color: #64748b; }
        .report-title { text-align: center; font-size: 16px; font-weight: bold; margin: 25px 0; }
        .summary { display: flex; gap: 20px; margin: 20px 0; }
        .summary-item { flex: 1; background: #f8fafc; padding: 15px; border-radius: 5px; }
        .summary-label { font-size: 10px; color: #64748b; text-transform: uppercase; }
        .summary-value { font-size: 24px; font-weight: bold; color: #0f172a; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #0f172a; color: white; padding: 10px 8px; text-align: left; font-size: 10px; }
        td { border: 1px solid #e2e8f0; padding: 8px; font-size: 10px; }
        tr:nth-child(even) { background: #f8fafc; }
        .rating { text-align: center; font-weight: bold; }
        .rating-high { color: #22c55e; }
        .rating-medium { color: #f59e0b; }
        .rating-low { color: #ef4444; }
        .chart-section { margin: 30px 0; }
        .chart-title { font-size: 12px; font-weight: bold; margin-bottom: 10px; }
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #64748b; border-top: 1px solid #e2e8f0; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('assets/Portal-LogoKKPRound-Warna.png') }}" alt="Logo KKP">
        <h1>BALAI PPMHKP LAMPUNG</h1>
        <p>Kementerian Kelautan dan Perikanan</p>
    </div>

    <div class="report-title">
        LAPORAN SURVEY KEPUASAN MASYARAKAT
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="summary-label">Total Responden</div>
            <div class="summary-value">{{ $surveys->count() }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Rata-rata Kualitas Pelayanan</div>
            <div class="summary-value">{{ $chartData['q1_kualitas_pelayanan'] ?? 0 }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Rata-rata Kompetensi Petugas</div>
            <div class="summary-value">{{ $chartData['q2_kompetensi_petugas'] ?? 0 }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Rata-rata Kecepatan</div>
            <div class="summary-value">{{ $chartData['q3_kecepatan'] ?? 0 }}</div>
        </div>
    </div>

    <div class="chart-section">
        <div class="chart-title">Rata-rata Hasil Survey</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Indikator Penilaian</th>
                    <th style="text-align:center;">Nilai Rata-rata</th>
                    <th style="text-align:center;">Predikat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Kualitas Pelayanan</td>
                    <td class="rating">{{ $chartData['q1_kualitas_pelayanan'] ?? 0 }}</td>
                    <td class="rating {{ $chartData['q1_kualitas_pelayanan'] >= 4 ? 'rating-high' : ($chartData['q1_kualitas_pelayanan'] >= 3 ? 'rating-medium' : 'rating-low') }}">
                        {{ $chartData['q1_kualitas_pelayanan'] >= 4 ? 'Sangat Baik' : ($chartData['q1_kualitas_pelayanan'] >= 3 ? 'Baik' : 'Perlu Perbaikan') }}
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Kompetensi Petugas</td>
                    <td class="rating">{{ $chartData['q2_kompetensi_petugas'] ?? 0 }}</td>
                    <td class="rating {{ $chartData['q2_kompetensi_petugas'] >= 4 ? 'rating-high' : ($chartData['q2_kompetensi_petugas'] >= 3 ? 'rating-medium' : 'rating-low') }}">
                        {{ $chartData['q2_kompetensi_petugas'] >= 4 ? 'Sangat Baik' : ($chartData['q2_kompetensi_petugas'] >= 3 ? 'Baik' : 'Perlu Perbaikan') }}
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Kecepatan Layanan</td>
                    <td class="rating">{{ $chartData['q3_kecepatan'] ?? 0 }}</td>
                    <td class="rating {{ $chartData['q3_kecepatan'] >= 4 ? 'rating-high' : ($chartData['q3_kecepatan'] >= 3 ? 'rating-medium' : 'rating-low') }}">
                        {{ $chartData['q3_kecepatan'] >= 4 ? 'Sangat Baik' : ($chartData['q3_kecepatan'] >= 3 ? 'Baik' : 'Perlu Perbaikan') }}
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Kenyamanan</td>
                    <td class="rating">{{ $chartData['q4_kenyamanan'] ?? 0 }}</td>
                    <td class="rating {{ $chartData['q4_kenyamanan'] >= 4 ? 'rating-high' : ($chartData['q4_kenyamanan'] >= 3 ? 'rating-medium' : 'rating-low') }}">
                        {{ $chartData['q4_kenyamanan'] >= 4 ? 'Sangat Baik' : ($chartData['q4_kenyamanan'] >= 3 ? 'Baik' : 'Perlu Perbaikan') }}
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Kenyamanan Sarpras</td>
                    <td class="rating">{{ $chartData['q5_kenyamanan_sarpras'] ?? 0 }}</td>
                    <td class="rating {{ $chartData['q5_kenyamanan_sarpras'] >= 4 ? 'rating-high' : ($chartData['q5_kenyamanan_sarpras'] >= 3 ? 'rating-medium' : 'rating-low') }}">
                        {{ $chartData['q5_kenyamanan_sarpras'] >= 4 ? 'Sangat Baik' : ($chartData['q5_kenyamanan_sarpras'] >= 3 ? 'Baik' : 'Perlu Perbaikan') }}
                    </td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Fasilitas</td>
                    <td class="rating">{{ $chartData['q6_fasilitas'] ?? 0 }}</td>
                    <td class="rating {{ $chartData['q6_fasilitas'] >= 4 ? 'rating-high' : ($chartData['q6_fasilitas'] >= 3 ? 'rating-medium' : 'rating-low') }}">
                        {{ $chartData['q6_fasilitas'] >= 4 ? 'Sangat Baik' : ($chartData['q6_fasilitas'] >= 3 ? 'Baik' : 'Perlu Perbaikan') }}
                    </td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Penampilan Petugas</td>
                    <td class="rating">{{ $chartData['q7_penampilan'] ?? 0 }}</td>
                    <td class="rating {{ $chartData['q7_penampilan'] >= 4 ? 'rating-high' : ($chartData['q7_penampilan'] >= 3 ? 'rating-medium' : 'rating-low') }}">
                        {{ $chartData['q7_penampilan'] >= 4 ? 'Sangat Baik' : ($chartData['q7_penampilan'] >= 3 ? 'Baik' : 'Perlu Perbaikan') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    @if($surveys->count() > 0)
    <div style="page-break-before: always;"></div>
    <div class="report-title" style="font-size: 14px;">DETAIL RESPONDEN</div>
    
    <table style="font-size: 9px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jenis Layanan</th>
                <th>Q1</th>
                <th>Q2</th>
                <th>Q3</th>
                <th>Q4</th>
                <th>Q5</th>
                <th>Q6</th>
                <th>Q7</th>
                <th>Rata-rata</th>
                <th>Saran/Masukan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($surveys as $index => $survey)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $survey->nama }}</td>
                <td>{{ $survey->email ?? '-' }}</td>
                <td>{{ $survey->jenis_layanan ?? '-' }}</td>
                <td class="rating">{{ $survey->q1_kualitas_pelayanan }}</td>
                <td class="rating">{{ $survey->q2_kompetensi_petugas }}</td>
                <td class="rating">{{ $survey->q3_kecepatan }}</td>
                <td class="rating">{{ $survey->q4_kenyamanan }}</td>
                <td class="rating">{{ $survey->q5_kenyamanan_sarpras }}</td>
                <td class="rating">{{ $survey->q6_fasilitas }}</td>
                <td class="rating">{{ $survey->q7_penampilan }}</td>
                <td class="rating">{{ number_format($survey->average_rating, 1) }}</td>
                <td style="max-width: 150px;">{{ $survey->saran_masukan ?? '-' }}</td>
                <td>{{ $survey->submitted_at ? $survey->submitted_at->format('d/m/Y H:i') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="footer">
        <p>Laporan ini dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>© {{ date('Y') }} Balai PPMHKP Lampung - Kementerian Kelautan dan Perikanan</p>
    </div>
</body>
</html>