<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();

            $table->foreignId('santri_id')
                ->constrained('santris')
                ->cascadeOnDelete();

            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->restrictOnDelete();

            $table->foreignId('mata_pelajaran_id')
                ->constrained('mata_pelajarans')
                ->restrictOnDelete();

            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajarans')
                ->restrictOnDelete();

            $table->unsignedTinyInteger('semester');

            $table->unsignedTinyInteger('nilai');

            $table->timestamps();

            $table->unique([
                'santri_id',
                'mata_pelajaran_id',
                'tahun_ajaran_id',
                'semester',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};