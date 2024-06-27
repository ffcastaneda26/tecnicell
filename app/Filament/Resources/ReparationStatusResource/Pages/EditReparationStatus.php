<?php

namespace App\Filament\Resources\ReparationStatusResource\Pages;

use App\Filament\Resources\ReparationStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReparationStatus extends EditRecord
{
    protected static string $resource = ReparationStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
