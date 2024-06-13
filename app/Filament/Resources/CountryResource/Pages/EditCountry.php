<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Filament\Resources\CountryResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditCountry extends EditRecord
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

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


    protected function getSavedNotificationTitle(): ?string
    {
        return  __('Country') . ' ' . __('Updated');
    }
}
