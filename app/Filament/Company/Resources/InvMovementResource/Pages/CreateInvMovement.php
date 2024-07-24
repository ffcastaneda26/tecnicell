<?php

namespace App\Filament\Company\Resources\InvMovementResource\Pages;

use App\Filament\Company\Resources\InvMovementResource;
use App\Models\KeyMovement;
use App\Models\WarehouseProduct;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\App;
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
        $key_movement = KeyMovement::findOrFail($data['key_movement_id']);
        if (!$key_movement->require_cost) {
            $warehouse_record = WarehouseProduct::where('warehouse_id', $data['warehouse_id'])
                ->where('product_id', $data['product_id'])
                ->first();
            $data['cost'] = $warehouse_record->average_cost;
        }
        $data['status'] = App::isLocale('en') ? 'Applied' : 'Aplicado';
        $data['user_id'] = Auth::user()->id;


        return $data;
    }
}
