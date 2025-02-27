<?php

namespace App\Models;

use App\Observers\BranchObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([BranchObserver::class])]
class Branch extends Model
{
    use HasFactory;
    protected $table = 'branches';

    protected $fillable = [
        'company_id',
        'name',
        'short',
        'slug',
        'email',
        'phone',
        'address',
        'num_ext',
        'num_int',
        'country_id',
        'state_id',
        'municipality',
        'city',
        'colony',
        'zipcode',
        'logo',
        'active',
        'user_id',
    ];

    protected function rfc(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtoupper($value),
            set: fn (string $value) => strtoupper($value),
        );
    }
    public function diagnostics(): HasMany
    {
        return $this->hasMany(Diagnostic::class);
    }
    public function cotizations(): HasMany
    {
        return $this->hasMany(Cotization::class);
    }
    public function reparations(): HasMany
    {
        return $this->hasMany(Reparation::class);
    }

    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    public function warranties():HasMany
    {
        return $this->hasMany(Warranty::class);
    }
    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function country():BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state():BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
