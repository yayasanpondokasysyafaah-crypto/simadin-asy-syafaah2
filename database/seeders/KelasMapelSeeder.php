<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\KelasMapel;

class KelasMapelSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = Kelas::all();

        foreach ($kelas as $k) {
            $mapels = MataPelajaran::where('kelas', $k->nama)->get();

            foreach ($mapels as $mapel) {
                KelasMapel::firstOrCreate([
                    'kelas_id' => $k->id,
                    'mata_pelajaran_id' => $mapel->id,
                ]);
            }
        }
    }
}