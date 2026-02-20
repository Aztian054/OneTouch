<?php

namespace App\Exports;

use App\Models\Sertifikat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SertifikatExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected array  $filters;
    protected ?int   $officerId;
    protected ?array $officerUserIds;
    protected ?int   $userId;

    public function __construct(
        array  $filters        = [],
        ?int   $officerId      = null,
        ?array $officerUserIds = null,
        ?int   $userId         = null
    ) {
        $this->filters        = $filters;
        $this->officerId      = $officerId;
        $this->officerUserIds = $officerUserIds;
        $this->userId         = $userId;
    }

    public function collection()
    {
        $query = Sertifikat::with('owner', 'creator');

        // Scope by role
        if ($this->userId !== null) {
            $query->where('user_id', $this->userId);
        } elseif ($this->officerId !== null) {
            $userIds = $this->officerUserIds ?? [];
            $oid     = $this->officerId;
            $query->where(function ($q) use ($oid, $userIds) {
                $q->where('created_by', $oid)->orWhereIn('user_id', $userIds);
            });
        }

        // Apply filters
        if (!empty($this->filters['jenis']))       $query->where('jenis_sertifikat', $this->filters['jenis']);
        if (!empty($this->filters['status_masa'])) $query->where('status_masa', $this->filters['status_masa']);
        if (!empty($this->filters['grade']))       $query->where('grade', $this->filters['grade']);
        if (!empty($this->filters['tahun']))       $query->whereYear('tanggal_terbit', $this->filters['tahun']);

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No', 'Nama Pemilik', 'Nomor Sertifikat', 'Ruang Lingkup',
            'Jenis Sertifikat', 'Grade', 'Tanggal Terbit', 'Tanggal Kadaluwarsa',
            'Status Masa', 'Status Proses', 'Petugas',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->nama_pemilik,
            $row->nomor_sertifikat,
            $row->ruang_lingkup,
            $row->jenis_sertifikat,
            $row->grade,
            $row->tanggal_terbit?->format('d/m/Y'),
            $row->tanggal_kadaluwarsa?->format('d/m/Y'),
            strtoupper($row->status_masa),
            $row->status_proses,
            $row->creator?->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
