<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekap_absensis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('santri_id')
                ->constrained('santris')
                ->cascadeOnDelete();

            $table->string('bulan'); // contoh: 2026-08

            $table->string('jenis'); // Keamanan / Madin

            $table->string('kegiatan')->nullable();

            $table->unsignedInteger('hadir')->default(0);
            $table->unsignedInteger('sakit')->default(0);
            $table->unsignedInteger('izin')->default(0);
            $table->unsignedInteger('alpa')->default(0);

            $table->timestamps();

            $table->unique([
                'santri_id',
                'bulan',
                'jenis',
                'kegiatan'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_absensis');
    }
};