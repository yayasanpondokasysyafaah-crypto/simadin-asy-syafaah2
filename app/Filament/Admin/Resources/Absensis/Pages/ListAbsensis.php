<?php

namespace App\Filament\Admin\Resources\Absensis\Pages;

use App\Filament\Admin\Resources\Absensis\AbsensiResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAbsensis extends ListRecords
{
    protected static string $resource = AbsensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('rekap')
                ->label('Rekap Absensi')
                ->icon('heroicon-o-chart-bar')
                ->url(fn () => AbsensiResource::getUrl('rekap')),

            Action::make('input')
                ->label('Input Absensi')
                ->icon('heroicon-o-pencil-square')
                ->url(fn () => AbsensiResource::getUrl('input')),

            CreateAction::make(),
        ];
    }
}