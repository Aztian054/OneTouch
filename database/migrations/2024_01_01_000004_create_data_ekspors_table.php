<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_ekspors', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('bulan')->unsigned(); // 1-12
            $table->year('tahun');
            $table->integer('frekuensi');            // Jumlah pengiriman
            $table->decimal('volume', 12, 2);        // Dalam Ton
            $table->decimal('nilai', 15, 2);         // Dalam USD
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_ekspors');
    }
};
