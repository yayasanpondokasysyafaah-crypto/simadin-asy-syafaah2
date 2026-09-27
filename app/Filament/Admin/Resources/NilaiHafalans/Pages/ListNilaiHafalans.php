<?php

namespace App\Filament\Admin\Resources\NilaiHafalans\Pages;

use App\Filament\Admin\Resources\NilaiHafalans\NilaiHafalanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNilaiHafalans extends ListRecords
{
    protected static string $resource = NilaiHafalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
