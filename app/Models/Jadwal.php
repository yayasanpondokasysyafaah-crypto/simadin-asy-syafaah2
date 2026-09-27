<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'kelas_mapel_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class);
    }
}