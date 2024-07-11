<?php

namespace App\Filament\Company\Resources\WarehouseProductResource\Pages;

use App\Filament\Company\Resources\WarehouseProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWarehouseProducts extends ListRecords
{
    protected static string $resource = WarehouseProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
