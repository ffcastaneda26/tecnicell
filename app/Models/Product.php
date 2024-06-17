<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable=[
        'brand_id',
        'name',
        'slug',
        'description',
        'image',
        'user_id'
    ];

    public function brand():BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
