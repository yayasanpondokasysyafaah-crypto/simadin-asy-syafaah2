<?php

namespace App\Filament\Admin\Resources\Santris\Schemas;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class SantriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nis')
                    ->label('NIS')
                    ->required()
                    ->maxLength(50),

                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('foto')
                    ->label('Foto Santri')
                    ->image()
                    ->disk('public')
                    ->directory('foto-santri')
                    ->imageEditor()
                    ->maxSize(2048),

                Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),

                TextInput::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->maxLength(100),

                DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir'),

                TextInput::make('alamat')
                    ->label('Alamat')
                    ->maxLength(255),

                TextInput::make('nama_ayah')
                    ->label('Nama Ayah')
                    ->maxLength(255),

                TextInput::make('nama_ibu')
                    ->label('Nama Ibu')
                    ->maxLength(255),

                TextInput::make('no_hp_wali')
                    ->label('No. HP Wali')
                    ->tel()
                    ->maxLength(30),

                Select::make('kelas_id')
                    ->label('Kelas')
                    ->options(
                        Kelas::query()
                            ->pluck('nama', 'id')
                    )
                    ->searchable()
                    ->required(),

                Select::make('tahun_ajaran_id')
                    ->label('Tahun Ajaran')
                    ->options(
                        TahunAjaran::query()
                            ->pluck('nama', 'id')
                    )
                    ->searchable()
                    ->required(),

                Select::make('status')
                ->label('Status')
                ->options([
                    'Aktif' => 'Aktif',
                    'Lulus' => 'Lulus',
                    'Keluar' => 'Keluar',
                    'Pindah' => 'Pindah',
                ])
                ->default('Aktif')
                ->required(),
            ]);
    }
}