<?php

namespace App\Filament\Admin\Resources\Absensis\Schemas;

use App\Models\Santri;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AbsensiForm
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
                    ->preload()
                    ->required(),

                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->default(now())
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Hadir' => 'Hadir',
                        'Sakit' => 'Sakit',
                        'Izin' => 'Izin',
                        'Alpa' => 'Alpa',
                    ])
                    ->default('Hadir')
                    ->required(),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(3),
            ]);
    }
}
