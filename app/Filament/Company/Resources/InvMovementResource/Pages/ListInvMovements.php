<?php

namespace App\Filament\Company\Resources\InvMovementResource\Pages;

use App\Filament\Company\Resources\InvMovementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvMovements extends ListRecords
{
    protected static string $resource = InvMovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
