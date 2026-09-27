<?php

namespace App\Filament\Admin\Resources\Gurus\Pages;

use App\Filament\Admin\Resources\Gurus\GuruResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGuru extends EditRecord
{
    protected static string $resource = GuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
