<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSkm extends Model
{
    protected $table    = 'data_skms';
    protected $fillable = ['tahun', 'target', 'realisasi'];
}
