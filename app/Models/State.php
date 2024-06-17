<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    protected $table = 'states';
    public $timestamps = false;
    protected $fillable =  [
        'name',
        'abbreviated',
        'contry_id'
    ];

    public function companies():HasMany
    {
        return $this->hasMany(Company::class);
    }
    
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}


