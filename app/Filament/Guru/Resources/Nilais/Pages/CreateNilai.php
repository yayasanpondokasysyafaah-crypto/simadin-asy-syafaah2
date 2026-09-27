<?php

namespace App\Filament\Guru\Resources\Nilais\Pages;

use App\Filament\Guru\Resources\Nilais\NilaiResource;
use App\Models\KelasMapel;
use App\Models\Nilai;
use App\Models\Santri;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CreateNilai extends CreateRecord
{
    protected static string $resource = NilaiResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $guruId = auth()->user()?->guru?->id;

        // Pastikan guru memang mengajar kelas + mata pelajaran tersebut.
        $ditugaskan = KelasMapel::query()
            ->where('guru_id', $guruId)
            ->where('kelas_id', $data['kelas_id'])
            ->where('mata_pelajaran_id', $data['mata_pelajaran_id'])
            ->exists();

        if (! $ditugaskan) {
            throw ValidationException::withMessages([
                'kelas_id' => 'Kelas dan mata pelajaran tersebut bukan tugas Anda.',
            ]);
        }

        $daftarNilai = collect($data['tabel_nilai'] ?? [])
            ->filter(fn ($nilai) => $nilai !== null && $nilai !== '');

        if ($daftarNilai->isEmpty()) {
            throw ValidationException::withMessages([
                'tabel_nilai' => 'Silakan isi minimal satu nilai santri.',
            ]);
        }

        $recordPertama = null;

        foreach ($daftarNilai as $santriId => $nilai) {

            // Pastikan santri memang berada di kelas yang dipilih.
            $santriValid = Santri::query()
                ->where('id', $santriId)
                ->where('kelas_id', $data['kelas_id'])
                ->where('status', 'Aktif')
                ->exists();

            if (! $santriValid) {
                continue;
            }

            $record = Nilai::updateOrCreate(
                [
                    'santri_id' => $santriId,
                    'mata_pelajaran_id' => $data['mata_pelajaran_id'],
                    'tahun_ajaran_id' => $data['tahun_ajaran_id'],
                    'daur' => $data['daur'],
                ],
                [
                    'kelas_id' => $data['kelas_id'],
                    'semester' => 1,
                    'nilai' => $nilai,
                ]
            );

            $recordPertama ??= $record;
        }

        if (! $recordPertama) {
            throw ValidationException::withMessages([
                'tabel_nilai' => 'Tidak ada nilai yang berhasil disimpan.',
            ]);
        }

        return $recordPertama;
    }
}