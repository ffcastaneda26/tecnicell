<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brands';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'image'
    ];

    public function devices():HasMany
    {
        return $this->hasMany(DeviceModel::class);
    }


}
