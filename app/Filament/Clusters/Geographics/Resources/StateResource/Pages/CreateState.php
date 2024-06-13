<?php

namespace App\Filament\Clusters\Geographics\Resources\StateResource\Pages;

use App\Filament\Clusters\Geographics\Resources\StateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateState extends CreateRecord
{
    protected static string $resource = StateResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


    protected function getCreatedNotificationTitle(): ?string
    {
        return  __('State') . ' ' . __('Created');

    }
}
