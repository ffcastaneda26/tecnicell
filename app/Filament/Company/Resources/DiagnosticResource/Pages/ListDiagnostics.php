<?php

namespace App\Filament\Company\Resources\DiagnosticResource\Pages;

use App\Filament\Company\Resources\DiagnosticResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiagnostics extends ListRecords
{
    protected static string $resource = DiagnosticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
