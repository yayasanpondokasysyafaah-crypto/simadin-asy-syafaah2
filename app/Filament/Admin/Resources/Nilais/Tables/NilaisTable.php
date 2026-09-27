<?php

namespace App\Filament\Admin\Resources\Nilais\Tables;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
                    ->searchable()
                    ->sortable(),

                TextColumn::make('daur')
                    ->label('Daur')
                    ->badge()
                    ->sortable(),

                TextColumn::make('semester')
                    ->label('Semester')
                    ->sortable(),

                TextColumn::make('nilai')
                    ->label('Nilai')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('tahunAjaran.nama')
                    ->label('Tahun Ajaran')
                    ->sortable(),

            ])

            ->filters([

                SelectFilter::make('kelas_id')
                    ->label('Kelas')
                    ->options(
                        Kelas::orderBy('nama')
                            ->pluck('nama', 'id')
                    ),

                SelectFilter::make('mata_pelajaran_id')
                    ->label('Mata Pelajaran')
                    ->options(
                        MataPelajaran::orderBy('nama')
                            ->pluck('nama', 'id')
                    ),

                SelectFilter::make('daur')
                    ->label('Daur')
                    ->options([
                        'Awwal' => 'Daur Awwal',
                        'Tsani' => 'Daur Tsani',
                        'Tsalis' => 'Daur Tsalis',
                    ]),

                SelectFilter::make('semester')
                    ->label('Semester')
                    ->options([
                        1 => 'Semester 1',
                        2 => 'Semester 2',
                    ]),

                SelectFilter::make('tahun_ajaran_id')
                    ->label('Tahun Ajaran')
                    ->options(
                        TahunAjaran::orderByDesc('nama')
                            ->pluck('nama', 'id')
                    ),

            ])

            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}