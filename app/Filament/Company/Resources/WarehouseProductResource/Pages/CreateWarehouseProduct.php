<?php

namespace App\Filament\Company\Resources\WarehouseProductResource\Pages;

use App\Filament\Company\Resources\WarehouseProductResource;
use App\Models\WarehouseProduct;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWarehouseProduct extends CreateRecord
{
    protected static string $resource = WarehouseProductResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if($data['warehouse_id'] && $data['product_id']){
            $exists = WarehouseProduct::where('warehouse_id',$data['warehouse_id'])
                                        ->where('product_id',$data['product_id'])
                                        ->exists();
            if($exists){
               
            }
        };
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
