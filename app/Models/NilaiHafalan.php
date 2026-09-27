<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiHafalan extends Model
{
    protected $fillable = [
        'santri_id',
        'hafalan_id',
        'tahun_ajaran_id',
        'daur',
        'nilai',
    ];

    protected $casts = [
        'nilai' => 'integer',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function hafalan(): BelongsTo
    {
        return $this->belongsTo(Hafalan::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}