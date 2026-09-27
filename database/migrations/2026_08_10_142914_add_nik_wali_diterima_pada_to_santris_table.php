<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            $table->string('nik')->nullable()->after('nis');
            $table->string('nama_wali')->nullable()->after('nama_ibu');
            $table->date('diterima_pada')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'nama_wali',
                'diterima_pada',
            ]);
        });
    }
};