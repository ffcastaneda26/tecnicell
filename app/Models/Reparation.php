<?php

namespace App\Models;

use App\Observers\ReparationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([ReparationObserver::class])]
class Reparation extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'client_id',
        'device_id',
        'start_date',
        'finish_date',
        'cost',
        'notes',
        'reparation_status_id'
    ];
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime:Y-m-d',
            'finish_date' => 'datetime:Y-m-d'
        ];
    }

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
        return $this->belongsTo(ReparationStatus::class,'reparation_status_id');
    }
}
