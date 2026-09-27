<?php

namespace App\Filament\Admin\Resources\TahunAjarans\Pages;

use App\Filament\Admin\Resources\TahunAjarans\TahunAjaranResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTahunAjaran extends EditRecord
{
    protected static string $resource = TahunAjaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
