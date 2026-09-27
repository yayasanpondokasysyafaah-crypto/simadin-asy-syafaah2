<?php

namespace App\Filament\Admin\Resources\Nilais\Pages;

use App\Filament\Admin\Resources\Nilais\NilaiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNilai extends EditRecord
{
    protected static string $resource = NilaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
