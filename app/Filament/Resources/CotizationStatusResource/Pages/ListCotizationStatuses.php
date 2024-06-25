<?php

namespace App\Filament\Resources\CotizationStatusResource\Pages;

use App\Filament\Resources\CotizationStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCotizationStatuses extends ListRecords
{
    protected static string $resource = CotizationStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
