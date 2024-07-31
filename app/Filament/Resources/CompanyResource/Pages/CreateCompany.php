<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CompanyResource;
use Filament\Support\Exceptions\Halt;

class CreateCompany extends CreateRecord
{
    protected static string $resource = CompanyResource::class;
    protected static bool $canCreateAnother= false;


    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['user_id'] = Auth::user()->id;
        $data['slug'] = Str::slug($data['name']);
        return $data;
    }

    public function CanCreate(): bool
    {
        return false;
        return Auth::user()->hasRole('Admin') || ! Auth::user()->companies->count();
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('Congratulations,your Company has been created');

    }
}
