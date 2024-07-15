<?php

namespace App\Filament\Company\Resources\WarehouseProductResource\Pages;

use App\Filament\Company\Resources\WarehouseProductResource;
use App\Models\WarehouseProduct;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWarehouseProduct extends CreateRecord
{
    protected static string $resource = WarehouseProductResource::class;
    

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
