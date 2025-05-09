<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceStatus extends Model
{
    use HasFactory;

    protected $table='device_statuses';
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function devices():HasMany
    {
        return $this->hasMany(Device::class,'device_status_id');
    }
}
