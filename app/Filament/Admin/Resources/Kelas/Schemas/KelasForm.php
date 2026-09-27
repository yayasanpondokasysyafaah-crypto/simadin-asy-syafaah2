<?php

namespace App\Filament\Admin\Resources\Kelas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KelasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Kelas')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),
            ]);
    }
}