<?php

namespace App\Filament\Admin\Resources\NilaiHafalans;

use App\Filament\Admin\Resources\NilaiHafalans\Pages\CreateNilaiHafalan;
use App\Filament\Admin\Resources\NilaiHafalans\Pages\EditNilaiHafalan;
use App\Filament\Admin\Resources\NilaiHafalans\Pages\ListNilaiHafalans;
use App\Filament\Admin\Resources\NilaiHafalans\Schemas\NilaiHafalanForm;
use App\Filament\Admin\Resources\NilaiHafalans\Tables\NilaiHafalansTable;
use App\Models\NilaiHafalan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NilaiHafalanResource extends Resource
{
    protected static ?string $model = NilaiHafalan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return NilaiHafalanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NilaiHafalansTable::configure($table);
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
            'index' => ListNilaiHafalans::route('/'),
            'create' => CreateNilaiHafalan::route('/create'),
            'edit' => EditNilaiHafalan::route('/{record}/edit'),
        ];
    }
}
