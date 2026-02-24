<?php

namespace App\Exports;

use App\Models\SkmSurvey;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SkmSurveyExport implements FromCollection, WithHeadings, WithMapping
{
    protected $params;

    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    public function collection()
    {
        $query = SkmSurvey::query();

        if ($this->params) {
            // Apply filters
            if (!empty($this->params['status']) && $this->params['status']) {
                $query->where('status', $this->params['status']);
            }
            if (!empty($this->params['jenis_layanan']) && $this->params['jenis_layanan']) {
                $query->where('jenis_layanan', $this->params['jenis_layanan']);
            }
            if (!empty($this->params['date_from']) && $this->params['date_from']) {
                $query->whereDate('submitted_at', '>=', $this->params['date_from']);
            }
            if (!empty($this->params['date_to']) && $this->params['date_to']) {
                $query->whereDate('submitted_at', '<=', $this->params['date_to']);
            }
            if (!empty($this->params['tahun']) && $this->params['tahun']) {
                $query->whereYear('submitted_at', $this->params['tahun']);
            }
        }

        return $query->orderBy('submitted_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'No. Telepon',
            'Jenis Layanan',
            'Q1: Kualitas Pelayanan',
            'Q2: Kompetensi Petugas',
            'Q3: Kecepatan',
            'Q4: Kenyamanan',
            'Q5: Kenyamanan Sarpras',
            'Q6: Fasilitas',
            'Q7: Penampilan',
            'Rata-rata Rating',
            'Saran Masukan',
            'IP Address',
            'Tanggal Submit',
            'Status',
        ];
    }

    public function map($survey): array
    {
        return [
            $survey->id,
            $survey->nama,
            $survey->email,
            $survey->no_telp,
            $survey->jenis_layanan,
            $survey->q1_kualitas_pelayanan,
            $survey->q2_kompetensi_petugas,
            $survey->q3_kecepatan,
            $survey->q4_kenyamanan,
            $survey->q5_kenyamanan_sarpras,
            $survey->q6_fasilitas,
            $survey->q7_penampilan,
            $survey->average_rating,
            $survey->saran_masukan,
            $survey->ip_address,
            $survey->submitted_at ? $survey->submitted_at->format('d/m/Y H:i:s') : '-',
            $survey->status,
        ];
    }
}