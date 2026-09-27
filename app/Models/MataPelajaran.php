<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $fillable = [
        'nama',
        'kelas',
    ];

    public function kelasMapels()
    {
        return $this->hasMany(KelasMapel::class);
    }
}