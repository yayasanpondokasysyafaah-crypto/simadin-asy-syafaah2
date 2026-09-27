<?php

namespace App\Filament\Admin\Resources\TahunAjarans\Pages;

use App\Filament\Admin\Resources\TahunAjarans\TahunAjaranResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTahunAjarans extends ListRecords
{
    protected static string $resource = TahunAjaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
