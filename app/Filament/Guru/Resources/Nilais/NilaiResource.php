<?php

namespace App\Filament\Guru\Resources\Nilais;

use App\Filament\Guru\Resources\Nilais\Pages\CreateNilai;
use App\Filament\Guru\Resources\Nilais\Pages\ListNilais;
use App\Filament\Guru\Resources\Nilais\Schemas\NilaiForm;
use App\Filament\Guru\Resources\Nilais\Tables\NilaisTable;
use App\Models\Nilai;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NilaiResource extends Resource
{
    protected static ?string $model = Nilai::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return NilaiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NilaisTable::configure($table);
    }

  public static function getEloquentQuery(): Builder
{
    $guruId = auth()->user()?->guru?->id;

    return parent::getEloquentQuery()
        ->whereExists(function ($query) use ($guruId) {
            $query
                ->selectRaw('1')
                ->from('kelas_mapels')
                ->whereColumn('kelas_mapels.kelas_id', 'nilais.kelas_id')
                ->whereColumn('kelas_mapels.mata_pelajaran_id', 'nilais.mata_pelajaran_id')
                ->where('kelas_mapels.guru_id', $guruId);
        });
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNilais::route('/'),
            'create' => CreateNilai::route('/create'),
        ];
    }
}