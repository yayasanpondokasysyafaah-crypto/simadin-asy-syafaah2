<?php

namespace App\Filament\Admin\Resources\KelasMapels\Pages;

use App\Filament\Admin\Resources\KelasMapels\KelasMapelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKelasMapels extends ListRecords
{
    protected static string $resource = KelasMapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
