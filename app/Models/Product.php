<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable=[
        'company_id',
        'brand_id',
        'device_model_id',
        'name',
        'sku',
        'description',
        'image',
        'user_id'
    ];

    public function inv_movements(): HasMany
    {
        return $this->hasMany(InvMovement::class);
    }

    public function warehouse_products(): HasMany
    {
        return $this->hasMany(WarehouseProduct::class);
    }

    public function brand():BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function device_model(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class);
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
