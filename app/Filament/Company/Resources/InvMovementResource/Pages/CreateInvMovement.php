<?php

namespace App\Filament\Company\Resources\InvMovementResource\Pages;

use App\Filament\Company\Resources\InvMovementResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateInvMovement extends CreateRecord
{
    protected static string $resource = InvMovementResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        return $data;
    }
}
