<?php

namespace App\Models;

use App\Observers\DiagnosticObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
 #[ObservedBy([DiagnosticObserver::class])]
class Diagnostic extends Model
{
    use HasFactory;
    protected $table='diagnostics';
    protected $fillable = [
        'device_id',
        'date',
        'techincal_id',
        'diagnosis',
        'active'
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }


    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function techincal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'techincal_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function device():BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
