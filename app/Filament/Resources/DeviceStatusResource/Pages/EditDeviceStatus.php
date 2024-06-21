<?php

namespace App\Filament\Resources\DeviceStatusResource\Pages;

use App\Filament\Resources\DeviceStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeviceStatus extends EditRecord
{
    protected static string $resource = DeviceStatusResource::class;

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

        return  __('Device Status') . ' ' . __('Updated');
    }
}
