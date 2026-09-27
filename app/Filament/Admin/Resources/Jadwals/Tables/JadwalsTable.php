<?php

namespace App\Filament\Admin\Resources\Jadwals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JadwalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kelasMapel.kelas.nama')
                    ->label('Kelas')
                    ->searchable(),

                TextColumn::make('kelasMapel.mataPelajaran.nama')
                    ->label('Mata Pelajaran')
                    ->searchable(),

                TextColumn::make('kelasMapel.guru.nama')
                    ->label('Guru')
                    ->searchable(),

                TextColumn::make('hari')
                    ->label('Hari')
                    ->sortable(),

                TextColumn::make('jam_mulai')
                    ->label('Mulai'),

                TextColumn::make('jam_selesai')
                    ->label('Selesai'),
            ])
            ->defaultSort('hari')
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