<?php

namespace App\Exports;

use App\Models\DataEkspor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class DataEksporExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = DataEkspor::query();

        // Apply filters
        if (!empty($this->filters['bulan'])) {
            $query->where('bulan', $this->filters['bulan']);
        }

        if (!empty($this->filters['tahun'])) {
            $query->where('tahun', $this->filters['tahun']);
        }

        if (!empty($this->filters['komoditas'])) {
            $query->where('komoditas', 'like', "%" . $this->filters['komoditas'] . "%");
        }

        if (!empty($this->filters['negara_tujuan'])) {
            $query->where('negara_tujuan', 'like', "%" . $this->filters['negara_tujuan'] . "%");
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Bulan',
            'Tahun',
            'Frekuensi Ekspor (Kali)',
            'Volume Ekspor (Ton)',
            'Nilai Ekspor (US$)',
            'Komoditas',
            'Negara Tujuan',
            'Unit Pelaksana',
            'Eksportir',
            'Tanggal Dibuat',
        ];
    }

    public function map($data): array
    {
        return [
            $data->id,
            $data->nama_bulan,
            $data->tahun,
            number_format($data->frekuensi, 0, ',', '.'),
            number_format($data->volume, 2, ',', '.'),
            number_format($data->nilai, 2, ',', '.'),
            $data->komoditas ?? '-',
            $data->negara_tujuan ?? '-',
            $data->unit_pelaksana ?? '-',
            $data->eksportir ?? '-',
            $data->created_at ? $data->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function title(): string
    {
        return 'Laporan Data Ekspor';
    }
}