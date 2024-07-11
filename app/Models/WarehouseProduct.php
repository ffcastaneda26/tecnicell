<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseProduct extends Model
{
    use HasFactory;

    protected $fillable =[
        'warehouse_id',
        'product_id',
        'price_sale',
        'last_purchase_price',
        'stock',
        'stock_available',
        'stock_min',
        'stock_max',
        'stock_reorder',
        'average_cost',
        'image',
        'active'
    ];

    public function warehouse():BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
