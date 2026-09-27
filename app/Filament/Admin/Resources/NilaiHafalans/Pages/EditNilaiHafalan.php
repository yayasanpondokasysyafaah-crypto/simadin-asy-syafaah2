<?php

namespace App\Filament\Admin\Resources\NilaiHafalans\Pages;

use App\Filament\Admin\Resources\NilaiHafalans\NilaiHafalanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNilaiHafalan extends EditRecord
{
    protected static string $resource = NilaiHafalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
