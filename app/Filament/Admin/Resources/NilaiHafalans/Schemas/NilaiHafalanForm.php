<?php

namespace App\Filament\Admin\Resources\NilaiHafalans\Schemas;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NilaiHafalanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pengaturan Nilai Hafalan')
                    ->schema([
                        Select::make('kelas_id')
                            ->label('Kelas')
                            ->options(
                                Kelas::query()
                                    ->orderBy('id')
                                    ->pluck('nama', 'id')
                            )
                            ->searchable()
                            ->live()
                            ->required(),

                        Select::make('daur')
                            ->label('Daur')
                            ->options([
                                'Awwal' => 'Awwal',
                                'Tsani' => 'Tsani',
                                'Tsalis' => 'Tsalis',
                            ])
                            ->live()
                            ->required(),

                        Select::make('tahun_ajaran_id')
                            ->label('Tahun Ajaran')
                            ->options(
                                TahunAjaran::query()
                                    ->orderByDesc('id')
                                    ->pluck('nama', 'id')
                            )
                            ->live()
                            ->required(),
                    ])
                    ->columns(3),

                ViewField::make('tabel_hafalan')
                ->default([])
                ->view('filament.nilai-hafalan.table')
                ->columnSpanFull(),
            ]);
    }
}