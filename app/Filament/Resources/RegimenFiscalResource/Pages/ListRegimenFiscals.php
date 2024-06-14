<?php

namespace App\Filament\Resources\RegimenFiscalResource\Pages;

use App\Filament\Resources\RegimenFiscalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegimenFiscals extends ListRecords
{
    protected static string $resource = RegimenFiscalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
