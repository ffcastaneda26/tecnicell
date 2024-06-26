<?php

namespace App\Filament\Company\Resources\CotizationResource\Pages;

use App\Filament\Company\Resources\CotizationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCotization extends CreateRecord
{
    protected static string $resource = CotizationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
