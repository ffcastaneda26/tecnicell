<?php

namespace App\Models;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    public $timestamps = false;
    protected $fillable =  [
        'country',
        'code',
        'url',
        'isdefault',
    ];

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

}
