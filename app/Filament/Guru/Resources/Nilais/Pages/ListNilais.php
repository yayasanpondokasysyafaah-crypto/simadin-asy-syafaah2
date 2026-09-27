<?php

namespace App\Filament\Guru\Resources\Nilais\Pages;

use App\Filament\Guru\Resources\Nilais\NilaiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNilais extends ListRecords
{
    protected static string $resource = NilaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
