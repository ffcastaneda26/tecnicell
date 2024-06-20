<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use HasFactory;
    protected $table='clients';
    protected $fillable = [
        'company_id',
        'name',
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
        'photo',
        'active',
        'notes',
        'user_id',
    ];

    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function country():BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function state():BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
