<?php

namespace App\Exports;

use App\Models\Inspeksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InspeksiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected array  $filters;
    protected ?int   $officerId;
    protected ?array $officerUserIds;

    public function __construct(
        array  $filters        = [],
        ?int   $officerId      = null,
        ?array $officerUserIds = null
    ) {
        $this->filters        = $filters;
        $this->officerId      = $officerId;
        $this->officerUserIds = $officerUserIds;
    }

    public function collection()
    {
        $query = Inspeksi::with('owner', 'creator');

        if ($this->officerId !== null) {
            $userIds = $this->officerUserIds ?? [];
            $oid     = $this->officerId;
            $query->where(function ($q) use ($oid, $userIds) {
                $q->where('created_by', $oid)->orWhereIn('user_id', $userIds);
            });
        }

        if (!empty($this->filters['kategori'])) $query->where('kategori', $this->filters['kategori']);
        if (!empty($this->filters['jenis']))    $query->where('jenis_sertifikat', $this->filters['jenis']);
        if (!empty($this->filters['tahun']))    $query->whereYear('tanggal', $this->filters['tahun']);

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No', 'Nama Perusahaan', 'Tanggal', 'Kategori',
            'Jenis Sertifikat', 'Status Berkas', 'Petugas',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->nama_perusahaan,
            $row->tanggal?->format('d/m/Y'),
            $row->kategori,
            $row->jenis_sertifikat,
            $row->status_berkas,
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
