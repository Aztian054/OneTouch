<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_ekspors', function (Blueprint $table) {
            $table->string('komoditas')->nullable()->after('nilai');
            $table->string('negara_tujuan')->nullable()->after('komoditas');
            $table->string('unit_pelaksana')->nullable()->after('negara_tujuan');
            $table->string('eksportir')->nullable()->after('unit_pelaksana');
        });
    }

    public function down(): void
    {
        Schema::table('data_ekspors', function (Blueprint $table) {
            $table->dropColumn(['komoditas', 'negara_tujuan', 'unit_pelaksana', 'eksportir']);
        });
    }
};