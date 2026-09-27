<?php

namespace App\Filament\Guru\Resources\Nilais\Schemas;

use App\Models\KelasMapel;
use App\Models\Nilai;
use App\Models\TahunAjaran;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NilaiForm
{
    public static function configure(Schema $schema): Schema
    {
        $guruId = auth()->user()?->guru?->id;

        $loadNilaiTersimpan = function ($set, $get) {
            $kelasId = $get('kelas_id');
            $mataPelajaranId = $get('mata_pelajaran_id');
            $tahunAjaranId = $get('tahun_ajaran_id');
            $daur = $get('daur');

            if (! $kelasId || ! $mataPelajaranId || ! $tahunAjaranId || ! $daur) {
                $set('tabel_nilai', []);

                return;
            }

            $nilai = Nilai::query()
                ->where('kelas_id', $kelasId)
                ->where('mata_pelajaran_id', $mataPelajaranId)
                ->where('tahun_ajaran_id', $tahunAjaranId)
                ->where('daur', $daur)
                ->pluck('nilai', 'santri_id')
                ->toArray();

            $set('tabel_nilai', $nilai);
        };

        return $schema
            ->components([
                Section::make('Pengaturan Nilai')
                    ->schema([
                        Select::make('kelas_id')
                            ->label('Kelas')
                            ->options(
                                KelasMapel::query()
                                    ->where('guru_id', $guruId)
                                    ->with('kelas')
                                    ->get()
                                    ->pluck('kelas.nama', 'kelas.id')
                                    ->unique()
                            )
                            ->searchable()
                            ->live()
                            ->afterStateUpdated($loadNilaiTersimpan)
                            ->required(),

                        Select::make('mata_pelajaran_id')
                            ->label('Mata Pelajaran')
                            ->options(function ($get) use ($guruId) {
                                $kelasId = $get('kelas_id');

                                if (! $kelasId) {
                                    return [];
                                }

                                return KelasMapel::query()
                                    ->where('guru_id', $guruId)
                                    ->where('kelas_id', $kelasId)
                                    ->with('mataPelajaran')
                                    ->get()
                                    ->pluck('mataPelajaran.nama', 'mata_pelajaran_id');
                            })
                            ->searchable()
                            ->live()
                            ->afterStateUpdated($loadNilaiTersimpan)
                            ->required(),

                        Select::make('tahun_ajaran_id')
                            ->label('Tahun Ajaran')
                            ->options(
                                TahunAjaran::query()
                                    ->orderByDesc('id')
                                    ->pluck('nama', 'id')
                            )
                            ->live()
                            ->afterStateUpdated($loadNilaiTersimpan)
                            ->required(),

                        Select::make('daur')
                            ->label('Daur')
                            ->options([
                                'Awwal' => 'Awwal',
                                'Tsani' => 'Tsani',
                                'Tsalis' => 'Tsalis',
                            ])
                            ->live()
                            ->afterStateUpdated($loadNilaiTersimpan)
                            ->required(),
                    ])
                    ->columns(3),

                ViewField::make('tabel_nilai')
                    ->default([])
                    ->view('filament.guru.nilai.table')
                    ->columnSpanFull(),
            ]);
    }
}