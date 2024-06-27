<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReparationStatus extends Model
{
    use HasFactory;

    protected $table = 'reparation_statuses';
    public $timestamps = false;

    protected $fillable = [
        'spanish',
        'english'
    ];
    public function reparations(): HasMany
    {
        return $this->hasMany(Reparation::class);
    }

}
