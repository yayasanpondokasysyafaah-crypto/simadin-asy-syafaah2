<?php

namespace App\Filament\Admin\Resources\Jadwals\Schemas;

use App\Models\KelasMapel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class JadwalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kelas_mapel_id')
                    ->label('Kelas & Mata Pelajaran')
                    ->options(
                        KelasMapel::with(['kelas', 'mataPelajaran', 'guru'])
                            ->get()
                            ->mapWithKeys(function ($item) {
                                return [
                                    $item->id => 
                                        ($item->kelas->nama ?? 'Kelas?')
                                        . ' - ' .
                                        ($item->mataPelajaran->nama ?? 'Mapel?')
                                        . ' - ' .
                                        ($item->guru->nama ?? 'Guru?'),
                                ];
                            })
                    )
                    ->searchable()
                    ->required(),

                Select::make('hari')
                    ->label('Hari')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                        'Minggu' => 'Minggu',
                    ])
                    ->required(),

                TimePicker::make('jam_mulai')
                    ->label('Jam Mulai')
                    ->seconds(false)
                    ->required(),

                TimePicker::make('jam_selesai')
                    ->label('Jam Selesai')
                    ->seconds(false)
                    ->required(),
            ]);
    }
}