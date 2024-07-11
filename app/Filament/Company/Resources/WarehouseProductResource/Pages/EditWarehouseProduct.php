<?php

namespace App\Filament\Company\Resources\WarehouseProductResource\Pages;

use App\Filament\Company\Resources\WarehouseProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWarehouseProduct extends EditRecord
{
    protected static string $resource = WarehouseProductResource::class;

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
}
