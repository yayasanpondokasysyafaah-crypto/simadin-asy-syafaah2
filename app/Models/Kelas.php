<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama',
    ];

    public function santris()
    {
        return $this->hasMany(Santri::class);
    }

    public function kelasMapels()
    {
        return $this->hasMany(KelasMapel::class);
    }
    public function hafalans()
    {
        return $this->hasMany(Hafalan::class);
    }
}