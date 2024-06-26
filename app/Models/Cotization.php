<?php

namespace App\Models;

use App\Filament\Resources\UserResource;
use App\Observers\CotizationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([CotizationObserver::class])]
class Cotization extends Model
{
    use HasFactory;

    protected $table='cotizations';
    protected $fillable = [
        'branch_id',
        'client_id',
        'device_id',
        'description',
        'estimated_cost',
        'client_approved',
        'cotization_status_id',
        'approval_date'
    ];

    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function branch():BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function client():BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function device():BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(CotizationStatus::class);
    }



}
