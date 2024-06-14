<?php

namespace App\Filament\Resources\RegimenFiscalResource\Pages;

use App\Filament\Resources\RegimenFiscalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRegimenFiscal extends CreateRecord
{
    protected static string $resource = RegimenFiscalResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


    protected function getCreatedNotificationTitle(): ?string
    {
        return  __('Tax Regimen') . ' ' . __('Created');

    }
}
