<?php

namespace App\Filament\Clusters\Geographics\Resources\StateResource\Pages;

use App\Filament\Clusters\Geographics\Resources\StateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditState extends EditRecord
{
    protected static string $resource = StateResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {

        return  __('State') . ' ' . __('Updated');
    }
}
