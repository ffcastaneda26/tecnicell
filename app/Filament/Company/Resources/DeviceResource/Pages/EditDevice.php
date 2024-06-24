<?php

namespace App\Filament\Company\Resources\DeviceResource\Pages;

use App\Filament\Company\Resources\DeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditDevice extends EditRecord
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
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
