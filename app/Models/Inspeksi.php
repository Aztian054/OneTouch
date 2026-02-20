<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspeksi extends Model
{
    protected $fillable = [
        'user_id', 'created_by', 'nama_perusahaan', 'tanggal',
        'kategori', 'jenis_sertifikat', 'berkas_path', 'status_berkas',
    ];

    protected $casts = ['tanggal' => 'date'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function getJenisList(): array
    {
        return ['HACCP','SKP','SPDI','HC','CBIB','CPIB','CPIB Kapal','CPPIB','CPOIB','CDOIB'];
    }
}
