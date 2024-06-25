<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'user_id',
    ];

    public function diagnostics():HasMany
    {
        return $this->hasMany(Diagnostic::class);
    }

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
        return $this->belongsTo(DeviceType::class,'device_type_id');
    }
    public function model():BelongsTo
    {
        return $this->belongsTo(DeviceModel::class,'device_model_id');
    }
    public function status():BelongsTo
    {
        return $this->belongsTo(DeviceStatus::class,'device_status_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
