<?php

namespace App\Filament\Resources\DeviceStatusResource\Pages;

use App\Filament\Resources\DeviceStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeviceStatuses extends ListRecords
{
    protected static string $resource = DeviceStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
