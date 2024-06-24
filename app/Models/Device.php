<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    use HasFactory;
    protected $tale='devices';
    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'brand_id',
        'device_type_id',
        'device_model_id',
        'serial_number',
        'imei',
        'device_status_id',
        'notes',
    ];

    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function brand():BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function type():BelongsTo
    {
        return $this->belongsTo(DeviceType::class);
    }
    public function model():BelongsTo
    {
        return $this->belongsTo(DeviceModel::class);
    }
    public function status():BelongsTo
    {
        return $this->belongsTo(DeviceStatus::class);
    }
}
