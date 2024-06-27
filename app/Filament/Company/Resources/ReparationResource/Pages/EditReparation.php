<?php

namespace App\Filament\Company\Resources\ReparationResource\Pages;

use App\Filament\Company\Resources\ReparationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReparation extends EditRecord
{
    protected static string $resource = ReparationResource::class;

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
