<?php

namespace App\Filament\Admin\Resources\Gurus\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GuruForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nip')
                    ->label('NIP')
                    ->unique(ignoreRecord: true),

                TextInput::make('nama')
                    ->label('Nama Guru')
                    ->required(),

                Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),

                Textarea::make('alamat')
                    ->label('Alamat'),

                TextInput::make('no_hp')
                    ->label('No. HP'),

                Toggle::make('aktif')
                    ->label('Guru Aktif')
                    ->default(true),
            ]);
    }
}