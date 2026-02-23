<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'event_date',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'event_date' => 'date',
    ];

    /**
     * Scope untuk mengambil berita aktif saja
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mengambil berita berdasarkan urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Scope untuk mengambil berita terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('event_date', 'desc')->orderBy('created_at', 'desc');
    }
}