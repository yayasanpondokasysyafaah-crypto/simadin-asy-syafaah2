<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Santri;

class Absensi extends Model
{
    protected $fillable = [
    'santri_id',
    'tanggal',
    'jenis',
    'kegiatan',
    'status',
    'keterangan',
];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}