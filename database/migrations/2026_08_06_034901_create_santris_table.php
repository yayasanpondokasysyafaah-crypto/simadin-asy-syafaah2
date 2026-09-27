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
    Schema::create('santris', function (Blueprint $table) {

        $table->id();

        $table->string('nis')->unique();

        $table->string('nama');

        $table->enum('jenis_kelamin', ['L','P']);

        $table->string('tempat_lahir')->nullable();

        $table->date('tanggal_lahir')->nullable();

        $table->text('alamat')->nullable();

        $table->string('nama_ayah')->nullable();

        $table->string('nama_ibu')->nullable();

        $table->string('no_hp_wali')->nullable();

        $table->foreignId('kelas_id')
                 ->constrained('kelas')
                 ->cascadeOnUpdate()
                 ->restrictOnDelete();

        $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajarans')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

        $table->enum('status',[
            'Aktif',
            'Lulus',
            'Keluar',
            'Pindah'
        ])->default('Aktif');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santris');
    }
};
