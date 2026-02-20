<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_skms', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->decimal('target', 5, 2);    // Persentase target
            $table->decimal('realisasi', 5, 2); // Persentase realisasi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_skms');
    }
};
