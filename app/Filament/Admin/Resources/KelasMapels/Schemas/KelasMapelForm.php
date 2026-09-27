<?php

namespace App\Filament\Admin\Resources\KelasMapels\Schemas;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class KelasMapelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->options(
                        Kelas::pluck('nama', 'id')
                    )
                    ->searchable()
                    ->required(),

                Select::make('mata_pelajaran_id')
                    ->label('Mata Pelajaran')
                    ->options(
                        MataPelajaran::pluck('nama', 'id')
                    )
                    ->searchable()
                    ->required(),

                Select::make('guru_id')
                    ->label('Guru')
                    ->options(
                        Guru::where('aktif', true)
                            ->pluck('nama', 'id')
                    )
                    ->searchable()
                    ->required(),
            ]);
    }
}