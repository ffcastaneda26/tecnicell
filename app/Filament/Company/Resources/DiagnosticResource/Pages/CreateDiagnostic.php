<?php

namespace App\Filament\Company\Resources\DiagnosticResource\Pages;

use App\Filament\Company\Resources\DiagnosticResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateDiagnostic extends CreateRecord
{
    protected static string $resource = DiagnosticResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
