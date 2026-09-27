<?php

namespace App\Filament\Admin\Resources\NilaiHafalans\Pages;

use App\Filament\Admin\Resources\NilaiHafalans\NilaiHafalanResource;
use App\Models\Hafalan;
use App\Models\NilaiHafalan;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateNilaiHafalan extends CreateRecord
{
    protected static string $resource = NilaiHafalanResource::class;

    public function hitungRataRata(): void
{
        $scores = $this->data['tabel_hafalan'] ?? [];
        $scores = $this->data['tabel_hafalan'] ?? [];

        $hasil = [];

        foreach ($scores as $santriId => $nilaiSantri) {
            $nilaiTerisi = collect($nilaiSantri)
                ->filter(fn ($nilai) => $nilai !== null && $nilai !== '');

            $jumlahKitab = count($nilaiSantri);

            if ($jumlahKitab > 0 && $nilaiTerisi->count() === $jumlahKitab) {
                $hasil[$santriId] = round($nilaiTerisi->avg(), 2);
            } else {
                $hasil[$santriId] = null;
            }
        }

        $this->data['rata_rata'] = $hasil;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $kelasId = $data['kelas_id'];
        $daur = $data['daur'];
        $tahunAjaranId = $data['tahun_ajaran_id'];

        $scores = $data['tabel_hafalan'] ?? [];

        $recordPertama = null;

        foreach ($scores as $santriId => $nilaiSantri) {
            foreach ($nilaiSantri as $hafalanId => $nilai) {

                if ($nilai === null || $nilai === '') {
                    continue;
                }

                $hafalan = Hafalan::where('id', $hafalanId)
                    ->where('kelas_id', $kelasId)
                    ->first();

                if (! $hafalan) {
                    continue;
                }

                $record = NilaiHafalan::updateOrCreate(
                    [
                        'santri_id' => $santriId,
                        'hafalan_id' => $hafalanId,
                        'tahun_ajaran_id' => $tahunAjaranId,
                        'daur' => $daur,
                    ],
                    [
                        'nilai' => (int) $nilai,
                    ]
                );

                $recordPertama ??= $record;
            }
        }

        if (! $recordPertama) {
            $recordPertama = NilaiHafalan::first();
        }

        return $recordPertama;
    }
}