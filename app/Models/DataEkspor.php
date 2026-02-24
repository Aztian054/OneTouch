<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataEkspor extends Model
{
    protected $table    = 'data_ekspors';
    protected $fillable = [
        'bulan',
        'tahun',
        'frekuensi',
        'volume',
        'nilai',
        'komoditas',
        'negara_tujuan',
        'unit_pelaksana',
        'eksportir',
    ];

    protected $casts = [
        'volume' => 'decimal:2',
        'nilai' => 'decimal:2',
    ];

    /**
     * Accessor untuk nama bulan
     */
    public function getNamaBulanAttribute()
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

        return $namaBulan[$this->bulan] ?? '';
    }

    /**
     * Static method untuk get nama bulan
     */
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
