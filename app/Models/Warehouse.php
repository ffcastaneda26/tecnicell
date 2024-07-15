<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'warehouses';

    protected $fillable = [
        'company_id',
        'branch_id',
        'name',
        'short',
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



    public function inv_movements(): HasMany
    {
        return $this->hasMany(InvMovement::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(WarehouseProduct::class);
    }

    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function branch():BelongsTo
    {
        return $this->belongsTo(Branch::class);
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
