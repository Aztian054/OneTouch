<?php

namespace Database\Seeders;

use App\Models\DataEkspor;
use Illuminate\Database\Seeder;

class EksporSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample realistic export data for Balai KIPM Lampung
        $data = [
            // 2025 Data - Q1
            [
                'bulan' => 1,
                'tahun' => 2025,
                'frekuensi' => 12,
                'volume' => 245.5,
                'nilai' => 1850000.00,
                'komoditas' => 'Udang Frozen',
                'negara_tujuan' => 'Singapura',
                'unit_pelaksana' => 'TIP Pelabuhan Panjang',
                'eksportir' => 'PT. Sumber Bahari',
            ],
            [
                'bulan' => 1,
                'tahun' => 2025,
                'frekuensi' => 8,
                'volume' => 180.2,
                'nilai' => 1450000.00,
                'komoditas' => 'Kerapu Fresh',
                'negara_tujuan' => 'Jepang',
                'unit_pelaksana' => 'TIP Bakauheni',
                'eksportir' => 'CV. Lampung Bahari',
            ],
            [
                'bulan' => 2,
                'tahun' => 2025,
                'frekuensi' => 15,
                'volume' => 320.8,
                'nilai' => 2200000.00,
                'komoditas' => 'Ikan Kerapu',
                'negara_tujuan' => 'Hong Kong',
                'unit_pelaksana' => 'TIP Pelabuhan Panjang',
                'eksportir' => 'PT. Nusantara Ekspor',
            ],
            [
                'bulan' => 2,
                'tahun' => 2025,
                'frekuensi' => 10,
                'volume' => 195.5,
                'nilai' => 1680000.00,
                'komoditas' => 'Tiram Kuping',
                'negara_tujuan' => 'Singapura',
                'unit_pelaksana' => 'TIP Bakauheni',
                'eksportir' => 'CV. Samudera',
            ],
            [
                'bulan' => 3,
                'tahun' => 2025,
                'frekuensi' => 18,
                'volume' => 385.2,
                'nilai' => 2850000.00,
                'komoditas' => 'Ikan Tuna',
                'negara_tujuan' => 'Jepang',
                'unit_pelaksana' => 'TIP Pelabuhan Panjang',
                'eksportir' => 'PT. Indo Tuna',
            ],
            [
                'bulan' => 3,
                'tahun' => 2025,
                'frekuensi' => 12,
                'volume' => 225.8,
                'nilai' => 1920000.00,
                'komoditas' => 'Udang Windu',
                'negara_tujuan' => 'Taiwan',
                'unit_pelaksana' => 'TIP Bakauheni',
                'eksportir' => 'PT. Jaya Ekspor',
            ],
            // 2025 Data - Q2
            [
                'bulan' => 4,
                'tahun' => 2025,
                'frekuensi' => 14,
                'volume' => 295.5,
                'nilai' => 2150000.00,
                'komoditas' => 'Ikan Kerapu',
                'negara_tujuan' => 'Singapura',
                'unit_pelaksana' => 'TIP Pelabuhan Panjang',
                'eksportir' => 'PT. Bahari Makmur',
            ],
            [
                'bulan' => 4,
                'tahun' => 2025,
                'frekuensi' => 9,
                'volume' => 185.2,
                'nilai' => 1580000.00,
                'komoditas' => 'Udang Vaname',
                'negara_tujuan' => 'Korea Selatan',
                'unit_pelaksana' => 'TIP Bakauheni',
                'eksportir' => 'CV. Ekspor Mandiri',
            ],
            [
                'bulan' => 5,
                'tahun' => 2025,
                'frekuensi' => 20,
                'volume' => 425.8,
                'nilai' => 3100000.00,
                'komoditas' => 'Ikan Tuna',
                'negara_tujuan' => 'Jepang',
                'unit_pelaksana' => 'TIP Pelabuhan Panjang',
                'eksportir' => 'PT. Samudra Raya',
            ],
            [
                'bulan' => 5,
                'tahun' => 2025,
                'frekuensi' => 11,
                'volume' => 215.5,
                'nilai' => 1850000.00,
                'komoditas' => 'Kerapu Fresh',
                'negara_tujuan' => 'Hong Kong',
                'unit_pelaksana' => 'TIP Bakauheni',
                'eksportir' => 'CV. Nusantara',
            ],
            [
                'bulan' => 6,
                'tahun' => 2025,
                'frekuensi' => 16,
                'volume' => 345.2,
                'nilai' => 2550000.00,
                'komoditas' => 'Udang Frozen',
                'negara_tujuan' => 'Singapura',
                'unit_pelaksana' => 'TIP Pelabuhan Panjang',
                'eksportir' => 'PT. Indotuna',
            ],
            [
                'bulan' => 6,
                'tahun' => 2025,
                'frekuensi' => 10,
                'volume' => 195.8,
                'nilai' => 1680000.00,
                'komoditas' => 'Ikan Kerapu',
                'negara_tujuan' => 'Taiwan',
                'unit_pelaksana' => 'TIP Bakauheni',
                'eksportir' => 'PT. Jaya Abadi',
            ],
        ];

        foreach ($data as $item) {
            DataEkspor::create($item);
        }

        $this->command->info('Sample ekspor data berhasil dibuat: ' . count($data) . ' records');
    }
}