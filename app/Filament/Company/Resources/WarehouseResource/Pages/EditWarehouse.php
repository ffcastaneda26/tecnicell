<?php

namespace App\Filament\Company\Resources\WarehouseResource\Pages;

use App\Filament\Company\Resources\WarehouseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditWarehouse extends EditRecord
{
    protected static string $resource = WarehouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $company = Auth::user()->companies->first();

        $data['company_id'] = $company->id;
        $data['user_id'] = Auth::user()->id;

        // Si no recibe datos de localización pone los de la empresa a la que pertenece

        if(!$data['email'] &&  $company->email){
            $data['email'] = $company->email;
        }

        if(!$data['phone'] &&  $company->phone){
            $data['phone'] = $company->phone;
        }

        if(!$data['address' &&  $company->address]){
            $data['address'] = $company->address;
        }


        if(!$data['num_ext'] &&  $company->num_ext){
            $data['num_ext'] = $company->num_ext;
        }

        if(!$data['num_int'] &&  $company->num_int){
            $data['num_int'] = $company->num_int;
        }

        if(!$data['country_id'] &&  $company->country_id){
            $data['country_id'] = $company->country_id;
        }

        if(!$data['state_id'] &&  $company->state_id){
            $data['state_id'] = $company->state_id;
        }

        if(!$data['municipality'] &&  $company->municipality){
            $data['municipality'] = $company->municipality;
        }

        if(!$data['city'] &&  $company->city){
            $data['city'] = $company->city;
        }

        if(!$data['colony'] &&  $company->colony){
            $data['colony'] = $company->colony;
        }

        if(!$data['zipcode'] &&  $company->zipcode){
            $data['zipcode'] = $company->zipcode;
        }
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
