<?php

namespace App\Filament\Company\Resources\KeyMovementResource\Pages;

use App\Filament\Company\Resources\KeyMovementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditKeyMovement extends EditRecord
{
    protected static string $resource = KeyMovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
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
