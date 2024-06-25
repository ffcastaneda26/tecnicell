<?php

namespace App\Filament\Company\Resources\DiagnosticResource\Pages;

use App\Filament\Company\Resources\DiagnosticResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateDiagnostic extends CreateRecord
{
    protected static string $resource = DiagnosticResource::class;
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {

    //     $data['company_id'] = Auth::user()->companies->first()->id;
    //     $data['user_id'] = Auth::user()->id;
    //     dd($data);
    //     return $data;
    // }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
