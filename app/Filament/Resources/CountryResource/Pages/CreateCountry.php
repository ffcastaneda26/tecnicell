<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Filament\Resources\CountryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateCountry extends CreateRecord
{
    protected static string $resource = CountryResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['isdefault']) {
            try {
                DB::beginTransaction();
                $sql = "Update countries set isdefault=0";
                DB::update($sql);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
            }
        }
        return $data;
    }
    protected function getCreatedNotificationTitle(): ?string
    {
        return  __('Country') . ' ' . __('Created');

    }

}
