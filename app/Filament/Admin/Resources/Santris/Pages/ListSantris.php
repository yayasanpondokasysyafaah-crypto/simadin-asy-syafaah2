<?php

namespace App\Filament\Admin\Resources\Santris\Pages;

use App\Filament\Admin\Resources\Santris\SantriResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSantris extends ListRecords
{
    protected static string $resource = SantriResource::class;

   protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('bulk')
                ->label('Buat Banyak')
                ->icon('heroicon-o-clipboard-document-list')
                ->url(fn () => SantriResource::getUrl('bulk')),

            CreateAction::make(),
        ];
    }
}
