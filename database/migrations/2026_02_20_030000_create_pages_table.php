<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // URL slug: 'beranda', 'layanan', dll
            $table->string('title'); // Judul halaman
            $table->string('subtitle')->nullable(); // Sub-judul atau tagline
            $table->text('content')->nullable(); // Konten HTML utama
            $table->string('hero_image')->nullable(); // Gambar header/banner
            $table->string('meta_title')->nullable(); // SEO title
            $table->text('meta_description')->nullable(); // SEO description
            $table->boolean('is_active')->default(true); // Status aktif/nonaktif
            $table->integer('order')->default(0); // Urutan di menu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};