<?php

namespace App\Filament\Company\Resources\DeviceResource\Pages;

use App\Filament\Company\Resources\DeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateDevice extends CreateRecord
{
    protected static string $resource = DeviceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['brand_id'] = $data['id_brand'];
        $data['user_id'] = Auth::user()->id;
        $data['company_id'] = Auth::user()->companies->first()->id;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
