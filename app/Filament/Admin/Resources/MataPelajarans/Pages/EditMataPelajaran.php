<?php

namespace App\Filament\Admin\Resources\MataPelajarans\Pages;

use App\Filament\Admin\Resources\MataPelajarans\MataPelajaranResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMataPelajaran extends EditRecord
{
    protected static string $resource = MataPelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
