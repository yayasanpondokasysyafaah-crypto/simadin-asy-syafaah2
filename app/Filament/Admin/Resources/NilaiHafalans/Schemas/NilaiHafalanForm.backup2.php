<?php

namespace App\Filament\Admin\Resources\NilaiHafalans\Schemas;

use App\Models\Hafalan;
use App\Models\Santri;
use App\Models\TahunAjaran;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NilaiHafalanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('santri_id')
                    ->label('Santri')
                    ->options(
                        Santri::query()
                            ->orderBy('nama')
                            ->pluck('nama', 'id')
                    )
                    ->searchable()
                    ->required(),

                Select::make('hafalan_id')
                    ->label('Hafalan / Kitab')
                    ->options(
                        Hafalan::query()
                            ->orderBy('kelas_id')
                            ->orderBy('urutan')
                            ->pluck('nama', 'id')
                    )
                    ->searchable()
                    ->required(),

                Select::make('tahun_ajaran_id')
                    ->label('Tahun Ajaran')
                    ->options(
                        TahunAjaran::query()
                            ->orderByDesc('id')
                            ->pluck('nama', 'id')
                    )
                    ->required(),

                Select::make('daur')
                    ->label('Daur')
                    ->options([
                        'Awwal' => 'Awwal',
                        'Tsani' => 'Tsani',
                        'Tsalis' => 'Tsalis',
                    ])
                    ->required(),

                TextInput::make('nilai')
                    ->label('Nilai')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->required(),
            ]);
    }
}