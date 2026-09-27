<?php

namespace App\Filament\Admin\Resources\Absensis;

use App\Filament\Admin\Resources\Absensis\Pages\CreateAbsensi;
use App\Filament\Admin\Resources\Absensis\Pages\EditAbsensi;
use App\Filament\Admin\Resources\Absensis\Pages\InputAbsensi;
use App\Filament\Admin\Resources\Absensis\Pages\ListAbsensis;
use App\Filament\Admin\Resources\Absensis\Pages\RekapAbsensi;
use App\Filament\Admin\Resources\Absensis\Schemas\AbsensiForm;
use App\Filament\Admin\Resources\Absensis\Tables\AbsensisTable;
use App\Models\Absensi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return AbsensiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AbsensisTable::configure($table);
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
        'index' => ListAbsensis::route('/'),
        'create' => CreateAbsensi::route('/create'),
        'edit' => EditAbsensi::route('/{record}/edit'),
        'input' => InputAbsensi::route('/input'),
        'rekap' => RekapAbsensi::route('/rekap'),
    ];
}
}
