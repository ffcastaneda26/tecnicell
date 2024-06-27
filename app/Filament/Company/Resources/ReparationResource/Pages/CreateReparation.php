<?php

namespace App\Filament\Company\Resources\ReparationResource\Pages;

use App\Filament\Company\Resources\ReparationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReparation extends CreateRecord
{
    protected static string $resource = ReparationResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
