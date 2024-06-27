<?php

namespace App\Filament\Company\Resources\ReparationResource\Pages;

use App\Filament\Company\Resources\ReparationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReparations extends ListRecords
{
    protected static string $resource = ReparationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
