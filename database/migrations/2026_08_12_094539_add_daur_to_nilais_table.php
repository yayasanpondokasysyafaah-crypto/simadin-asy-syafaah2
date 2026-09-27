<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->enum('daur', [
                'Awwal',
                'Tsani',
                'Tsalis',
            ])->after('tahun_ajaran_id');

            $table->dropUnique([
                'santri_id',
                'mata_pelajaran_id',
                'tahun_ajaran_id',
                'semester',
            ]);

            $table->unique([
                'santri_id',
                'mata_pelajaran_id',
                'tahun_ajaran_id',
                'daur',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->dropUnique([
                'santri_id',
                'mata_pelajaran_id',
                'tahun_ajaran_id',
                'daur',
            ]);

            $table->unique([
                'santri_id',
                'mata_pelajaran_id',
                'tahun_ajaran_id',
                'semester',
            ]);

            $table->dropColumn('daur');
        });
    }
};