<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->string('berkas_path', 500)->nullable()->after('status_proses');
            $table->enum('status_berkas', ['Terkirim', 'Tidak Ada'])->default('Tidak Ada')->after('berkas_path');
        });
    }

    public function down(): void
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->dropColumn(['berkas_path', 'status_berkas']);
        });
    }
};
