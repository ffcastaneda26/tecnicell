<?php

namespace App\Filament\Resources\CotizationStatusResource\Pages;

use App\Filament\Resources\CotizationStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCotizationStatus extends EditRecord
{
    protected static string $resource = CotizationStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
