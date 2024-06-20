<?php

namespace App\Filament\Company\Resources\ClientResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Company\Resources\ClientResource;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $data['company_id'] = Auth::user()->companies->first()->id;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
