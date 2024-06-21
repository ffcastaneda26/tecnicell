<?php

namespace App\Filament\Resources\DeviceStatusResource\Pages;

use App\Filament\Resources\DeviceStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDeviceStatus extends CreateRecord
{
    protected static string $resource = DeviceStatusResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
