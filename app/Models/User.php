<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'username', 'email', 'password', 'role', 'company_name', 'officer_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed'];

    // User yang menjadi officer penanggung jawab
    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    // User-user yang dibawahi officer ini
    public function managedUsers()
    {
        return $this->hasMany(User::class, 'officer_id');
    }

    public function sertifikats()
    {
        return $this->hasMany(Sertifikat::class, 'user_id');
    }

    public function inspeksis()
    {
        return $this->hasMany(Inspeksi::class, 'user_id');
    }

    // Sertifikat yang dibuat oleh officer ini
    public function createdSertifikats()
    {
        return $this->hasMany(Sertifikat::class, 'created_by');
    }

    public function createdInspeksis()
    {
        return $this->hasMany(Inspeksi::class, 'created_by');
    }

    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isOfficer(): bool  { return $this->role === 'officer'; }
    public function isUser(): bool     { return $this->role === 'user'; }
}
