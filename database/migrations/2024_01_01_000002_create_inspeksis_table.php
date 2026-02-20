<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspeksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');          // FK ke users (pemilik/owner)
            $table->unsignedBigInteger('created_by')->nullable(); // FK ke officer yang input
            $table->string('nama_perusahaan');
            $table->date('tanggal');
            $table->enum('kategori', ['Inspeksi','Surveilan']);
            $table->enum('jenis_sertifikat', ['HACCP','SKP','SPDI','HC','CBIB','CPIB','CPIB Kapal','CPPIB','CPOIB','CDOIB']);
            $table->string('berkas_path', 500)->nullable();
            $table->enum('status_berkas', ['Terkirim','Tidak Ada'])->default('Tidak Ada');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspeksis');
    }
};
