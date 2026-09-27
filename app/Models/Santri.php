<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Absensi;

class Santri extends Model
{
    protected $fillable = [
        'nis',
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nama_ayah',
        'nama_ibu',
        'nama_wali',
        'no_hp_wali',
        'kelas_id',
        'tahun_ajaran_id',
        'status',
        'diterima_pada',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'diterima_pada' => 'date',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
    public function absensis()
    {
    return $this->hasMany(Absensi::class);
    }
    public function nilaiHafalans()
    {
        return $this->hasMany(NilaiHafalan::class);
    }
}