<?php

namespace App\Models;

use App\Observers\WarrentyObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use PHPUnit\Event\TestRunner\WarningTriggered;

#[ObservedBy([WarrentyObserver::class])]
class Warranty extends Model
{
    use HasFactory;
    protected $table = 'warranties';
    protected $fillable = [
        'branch_id',
        'start_date',
        'due_date',
        'reparation_id',
        'active'
    ];

    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function branch():BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }


    public function reparation(): HasOne
    {
        return $this->hasOne(Reparation::class);
    }

}
