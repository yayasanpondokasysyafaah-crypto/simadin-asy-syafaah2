<?php

namespace App\Filament\Admin\Resources\TahunAjarans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TahunAjaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Tahun Ajaran')
                    ->placeholder('2026/2027')
                    ->required()
                    ->maxLength(20),

                Toggle::make('aktif')
                    ->label('Tahun Ajaran Aktif'),
            ]);
    }
}