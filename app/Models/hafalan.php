<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hafalan extends Model
{
    protected $fillable = [
        'kelas_id',
        'nama',
        'urutan',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function nilaiHafalans(): HasMany
    {
        return $this->hasMany(NilaiHafalan::class);
    }
}