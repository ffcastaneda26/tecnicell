<?php

namespace App\Filament\Company\Resources\WarrantyResource\Pages;

use App\Filament\Company\Resources\WarrantyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWarranty extends CreateRecord
{
    protected static string $resource = WarrantyResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
