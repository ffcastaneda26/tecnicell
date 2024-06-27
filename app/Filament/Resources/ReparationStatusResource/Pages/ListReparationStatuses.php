<?php

namespace App\Filament\Resources\ReparationStatusResource\Pages;

use App\Filament\Resources\ReparationStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReparationStatuses extends ListRecords
{
    protected static string $resource = ReparationStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
