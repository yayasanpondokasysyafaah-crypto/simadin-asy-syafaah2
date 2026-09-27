<?php

namespace App\Filament\Guru\Resources\Nilais\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NilaisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('santri.nis')
                    ->label('NIS')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('santri.nama')
                    ->label('Nama Santri')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kelas.nama')
                    ->label('Kelas')
                    ->sortable(),

                TextColumn::make('mataPelajaran.nama')
                    ->label('Mata Pelajaran')
                    ->wrap(),

                TextColumn::make('daur')
                    ->label('Daur')
                    ->badge()
                    ->sortable(),

                TextColumn::make('tahunAjaran.nama')
                    ->label('Tahun Ajaran')
                    ->sortable(),

                TextColumn::make('semester')
                    ->label('Semester')
                    ->sortable(),

                TextColumn::make('nilai')
                    ->label('Nilai')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('kelas_id')
                    ->label('Kelas')
                    ->relationship('kelas', 'nama')
                    ->searchable()
                    ->preload(),

                \Filament\Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Putra',
                        'P' => 'Putri',
                    ])
                    ->query(function ($query, array $data) {
                        if (filled($data['value'] ?? null)) {
                            $query->whereHas('santri', function ($q) use ($data) {
                                $q->where('jenis_kelamin', $data['value']);
                            });
                        }
                    }),
            ]);
    }
}