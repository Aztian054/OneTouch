<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataEkspor extends Model
{
    protected $table    = 'data_ekspors';
    protected $fillable = ['bulan', 'tahun', 'frekuensi', 'volume', 'nilai'];
}
