<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan User - ONE TOUCH</title>
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
            padding: 10px 12px;
            font-size: 10px;
            font-weight: 600;
            text-align: left;
            color: #475569;
            border-bottom: 2px solid #e2e8f0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
            color: #334155;
        }
        tr:last-child td { border-bottom: none; }
        tr:nth-child(even) { background: #f8fafc; }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 600;
        }
        .badge-aktif { background: #dcfce7; color: #15803d; }
        .badge-nonaktif { background: #fee2e2; color: #b91c1c; }
        .badge-admin { background: rgba(212,175,55,.15); color: #92660c; }
        .badge-officer { background: rgba(59,130,246,.12); color: #1d4ed8; }
        .badge-user { background: rgba(34,197,94,.12); color: #166534; }
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
            grid-template-columns: repeat(4, 1fr);
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
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <img src="{{ public_path('assets/Portal-LogoKKPRound-Warna.png') }}" class="header-logo" alt="KKP">
            <div class="header-title">
                <h1>Laporan User</h1>
                <p>Sistem Manajemen Sertifikat dan Inspeksi - Balai PPMHKP Lampung</p>
            </div>
        </div>
        <div class="header-meta">
            <div><strong>Tanggal:</strong> {{ now()->format('d/m/Y') }}</div>
            <div><strong>Total Data:</strong> {{ $users->count() }} User</div>
        </div>
    </div>

    <div class="summary">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-value">{{ $users->where('role', 'admin')->count() }}</div>
                <div class="summary-label">Admin</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $users->where('role', 'officer')->count() }}</div>
                <div class="summary-label">Petugas</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $users->where('role', 'user')->count() }}</div>
                <div class="summary-label">User</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">{{ $users->where(fn($u) => $u->is_active ?? true)->count() }}</div>
                <div class="summary-label">Aktif</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Nama Perusahaan</th>
                <th>Petugas</th>
                <th>Status</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $user)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email ?? '-' }}</td>
                <td>
                    <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                </td>
                <td>{{ $user->company_name ?? '-' }}</td>
                <td>{{ $user->officer?->name ?? '-' }}</td>
                <td>
                    <span class="badge {{ $user->is_active ?? true ? 'badge-aktif' : 'badge-nonaktif' }}">
                        {{ $user->is_active ?? true ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td>{{ $user->created_at?->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center; padding: 30px; color: #64748b;">
                    Tidak ada data user
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