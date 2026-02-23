<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'content',
        'hero_image',
        'meta_title',
        'meta_description',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'content' => 'array', // Cast content to array if using JSON
    ];

    /**
     * Scope untuk mengambil halaman aktif saja
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mengambil halaman berdasarkan urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Scope untuk mencari halaman berdasarkan slug
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}