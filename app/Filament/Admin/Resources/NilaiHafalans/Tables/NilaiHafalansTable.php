<?php

namespace App\Filament\Admin\Resources\NilaiHafalans\Tables;

use App\Models\NilaiHafalan;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NilaiHafalansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                NilaiHafalan::query()
                    ->selectRaw('
                        MIN(nilai_hafalans.id) as id,
                        nilai_hafalans.santri_id,
                        nilai_hafalans.tahun_ajaran_id,
                        nilai_hafalans.daur,
                        AVG(nilai_hafalans.nilai) as nilai_rata_rata,
                        GROUP_CONCAT(hafalans.nama, ", ") as hafalan_nama
                    ')
                    ->join(
                        'hafalans',
                        'hafalans.id',
                        '=',
                        'nilai_hafalans.hafalan_id'
                    )
                    ->groupBy(
                        'nilai_hafalans.santri_id',
                        'nilai_hafalans.tahun_ajaran_id',
                        'nilai_hafalans.daur'
                    )
            )
            ->columns([
                TextColumn::make('santri.nis')
                    ->label('NIS')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('santri.nama')
                    ->label('Nama Santri')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('santri.kelas.nama')
                    ->label('Kelas')
                    ->sortable(),

                TextColumn::make('hafalan_nama')
                    ->label('Hafalan / Kitab')
                    ->wrap(),

                TextColumn::make('daur')
                    ->label('Daur')
                    ->badge()
                    ->sortable(),

                TextColumn::make('tahunAjaran.nama')
                    ->label('Tahun Ajaran')
                    ->sortable(),

                TextColumn::make('nilai_rata_rata')
                    ->label('Nilai')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}