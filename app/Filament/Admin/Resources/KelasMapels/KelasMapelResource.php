<?php

namespace App\Filament\Admin\Resources\KelasMapels;

use App\Filament\Admin\Resources\KelasMapels\Pages\CreateKelasMapel;
use App\Filament\Admin\Resources\KelasMapels\Pages\EditKelasMapel;
use App\Filament\Admin\Resources\KelasMapels\Pages\ListKelasMapels;
use App\Filament\Admin\Resources\KelasMapels\Schemas\KelasMapelForm;
use App\Filament\Admin\Resources\KelasMapels\Tables\KelasMapelsTable;
use App\Models\KelasMapel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KelasMapelResource extends Resource
{
    protected static ?string $model = KelasMapel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return KelasMapelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KelasMapelsTable::configure($table);
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
            'index' => ListKelasMapels::route('/'),
            'create' => CreateKelasMapel::route('/create'),
            'edit' => EditKelasMapel::route('/{record}/edit'),
        ];
    }
}
