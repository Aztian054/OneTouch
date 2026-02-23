<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SkmSurvey extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'no_telp',
        'jenis_layanan',
        'q1_kualitas_pelayanan',
        'q2_kompetensi_petugas',
        'q3_kecepatan',
        'q4_kenyamanan',
        'q5_kenyamanan_sarpras',
        'q6_fasilitas',
        'q7_penampilan',
        'saran_masukan',
        'ip_address',
        'submitted_at',
        'status',
    ];

    protected $casts = [
        'q1_kualitas_pelayanan' => 'decimal:1',
        'q2_kompetensi_petugas' => 'decimal:1',
        'q3_kecepatan' => 'decimal:1',
        'q4_kenyamanan' => 'decimal:1',
        'q5_kenyamanan_sarpras' => 'decimal:1',
        'q6_fasilitas' => 'decimal:1',
        'q7_penampilan' => 'decimal:1',
        'submitted_at' => 'datetime',
    ];

    public function getAverageRatingAttribute()
    {
        return ($this->q1_kualitas_pelayanan +
                $this->q2_kompetensi_petugas +
                $this->q3_kecepatan +
                $this->q4_kenyamanan +
                $this->q5_kenyamanan_sarpras +
                $this->q6_fasilitas +
                $this->q7_penampilan) / 7;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAvgRating($query)
    {
        $result = $query->avg(DB::raw('(
            q1_kualitas_pelayanan +
            q2_kompetensi_petugas +
            q3_kecepatan +
            q4_kenyamanan +
            q5_kenyamanan_sarpras +
            q6_fasilitas +
            q7_penampilan
        ) / 7'));
        
        return round($result, 1);
    }
}
