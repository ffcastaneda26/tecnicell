<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'short',
        'slug',
        'Rfc',
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
        'permitted_branches',
        'active',
        'user_id',
    ];


    protected static function boot()
    {
        parent::boot();

        static::created(function (Company $company) {
            $company->attachUser();
        });
    }

    protected function rfc(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtoupper($value),
            set: fn (string $value) => strtoupper($value),
        );
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function key_movements(): HasMany
    {
        return $this->hasMany(KeyMovement::class);
    }
    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function products():HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }
    public function country():BelongsTo
    {
        return $this->belongsTo(Country::class);
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

    public function warranties():HasMany
    {
        return $this->hasMany(Warranty::class);
    }


    public function state():BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /** De apoyo y control */
    public function attachUser($user = null)
    {
        $user = $user ?? Auth::user();
        if($user){
            $this->users()->attach($user->id);
        }
    }


}
