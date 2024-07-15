<?php

namespace App\Filament\Company\Resources\InvMovementResource\Pages;

use App\Filament\Company\Resources\InvMovementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditInvMovement extends EditRecord
{
    protected static string $resource = InvMovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        return $data;
    }

}
