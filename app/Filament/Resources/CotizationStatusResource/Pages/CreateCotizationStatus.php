<?php

namespace App\Filament\Resources\CotizationStatusResource\Pages;

use App\Filament\Resources\CotizationStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCotizationStatus extends CreateRecord
{
    protected static string $resource = CotizationStatusResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
