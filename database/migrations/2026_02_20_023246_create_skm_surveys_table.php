<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('skm_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('jenis_layanan')->nullable();
            $table->decimal('q1_kualitas_pelayanan', 2, 1)->default(0);
            $table->decimal('q2_kompetensi_petugas', 2, 1)->default(0);
            $table->decimal('q3_kecepatan', 2, 1)->default(0);
            $table->decimal('q4_kenyamanan', 2, 1)->default(0);
            $table->decimal('q5_kenyamanan_sarpras', 2, 1)->default(0);
            $table->decimal('q6_fasilitas', 2, 1)->default(0);
            $table->decimal('q7_penampilan', 2, 1)->default(0);
            $table->text('saran_masukan')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skm_surveys');
    }
};
