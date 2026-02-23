<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $fillable = [
        'user_id', 'created_by', 'nama_pemilik', 'nomor_sertifikat', 'ruang_lingkup',
        'jenis_sertifikat', 'grade', 'tanggal_terbit', 'tanggal_kadaluwarsa',
        'status_masa', 'status_proses', 'berkas_path', 'status_berkas',
    ];

    protected $casts = [
        'tanggal_terbit'      => 'date',
        'tanggal_kadaluwarsa' => 'date',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updateStatusMasa(): void
    {
        $today = now()->startOfDay();
        $exp   = $this->tanggal_kadaluwarsa;

        if ($exp->lt($today)) {
            $this->status_masa = 'expired';
        } elseif ($exp->lte($today->copy()->addDays(15))) {
            $this->status_masa = 'warning';
        } else {
            $this->status_masa = 'aktif';
        }
        $this->save();
    }

    public static function getJenisList(): array
    {
        return ['HACCP','SKP','SPDI','HC','CBIB','CPIB','CPIB Kapal','CPPIB','CPOIB','CDOIB'];
    }

    public static function computeStatusMasa(?string $tanggalKadaluwarsa): string
    {
        if (!$tanggalKadaluwarsa) return 'aktif';
        $today = now()->startOfDay();
        $exp   = \Carbon\Carbon::parse($tanggalKadaluwarsa)->startOfDay();

        if ($exp->lt($today)) {
            return 'expired';
        } elseif ($exp->lte($today->copy()->addDays(15))) {
            return 'warning';
        }
        return 'aktif';
    }
}
