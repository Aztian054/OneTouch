<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataEkspor extends Model
{
    protected $table    = 'data_ekspors';
    protected $fillable = ['bulan', 'tahun', 'frekuensi', 'volume', 'nilai'];

    public static function getNamaBulan($bulan)
    {
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $namaBulan[$bulan] ?? '';
    }
}
