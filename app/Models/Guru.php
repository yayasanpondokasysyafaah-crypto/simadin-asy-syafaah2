<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelasMapels()
    {
        return $this->hasMany(KelasMapel::class);
    }
}