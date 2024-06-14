<?php

namespace App\Filament\Resources\RegimenFiscalResource\Pages;

use App\Filament\Resources\RegimenFiscalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegimenFiscal extends EditRecord
{
    protected static string $resource = RegimenFiscalResource::class;

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

    protected function getSavedNotificationTitle(): ?string
    {

        return  __('Tax Regimen') . ' ' . __('Updated');
    }
}
