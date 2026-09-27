<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapAbsensi extends Model
{
    protected $table = 'rekap_absensis';

    protected $fillable = [
        'santri_id',
        'bulan',
        'jenis',
        'kegiatan',
        'hadir',
        'sakit',
        'izin',
        'alpa',
    ];

    protected $casts = [
        'hadir' => 'integer',
        'sakit' => 'integer',
        'izin' => 'integer',
        'alpa' => 'integer',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}