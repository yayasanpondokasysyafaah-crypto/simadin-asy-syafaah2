<?php

namespace App\Filament\Admin\Resources\MataPelajarans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MataPelajaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Mata Pelajaran')
                    ->required()
                    ->maxLength(255),

                TextInput::make('kelas')
                    ->label('Kelas')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(6)
                    ->required(),
            ]);
    }
}