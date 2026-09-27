<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $fillable = [
        'santri_id',
        'kelas_id',
        'mata_pelajaran_id',
        'tahun_ajaran_id',
        'semester',
        'daur',
        'nilai',
    ];

    protected $casts = [
        'nilai' => 'integer',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}