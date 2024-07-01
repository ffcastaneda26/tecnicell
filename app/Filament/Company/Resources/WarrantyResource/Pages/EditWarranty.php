<?php

namespace App\Filament\Company\Resources\WarrantyResource\Pages;

use App\Filament\Company\Resources\WarrantyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWarranty extends EditRecord
{
    protected static string $resource = WarrantyResource::class;

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
