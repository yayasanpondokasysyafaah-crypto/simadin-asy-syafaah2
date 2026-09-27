<?php

namespace App\Filament\Admin\Resources\KelasMapels\Pages;

use App\Filament\Admin\Resources\KelasMapels\KelasMapelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKelasMapel extends EditRecord
{
    protected static string $resource = KelasMapelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
