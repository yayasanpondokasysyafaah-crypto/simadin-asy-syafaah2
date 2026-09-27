<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_hafalans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('santri_id')
                ->constrained('santris')
                ->restrictOnDelete();

            $table->foreignId('hafalan_id')
                ->constrained('hafalans')
                ->restrictOnDelete();

            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajarans')
                ->restrictOnDelete();

            $table->string('daur', 20);
            $table->unsignedInteger('nilai')->nullable();

            $table->timestamps();

            $table->unique([
                'santri_id',
                'hafalan_id',
                'tahun_ajaran_id',
                'daur',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_hafalans');
    }
};