<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropUnique('absensis_santri_id_tanggal_unique');

            $table->unique(
                ['santri_id', 'tanggal', 'jenis', 'kegiatan'],
                'absensis_santri_tanggal_jenis_kegiatan_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropUnique('absensis_santri_tanggal_jenis_kegiatan_unique');

            $table->unique(
                ['santri_id', 'tanggal'],
                'absensis_santri_id_tanggal_unique'
            );
        });
    }
};