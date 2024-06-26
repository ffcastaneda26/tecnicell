<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CotizationStatus extends Model
{
    use HasFactory;
    protected $table = 'cotization_statuses';
    public $timestamps = false;

    protected $fillable = [
        'spanish',
        'english'
    ];

    public function cotizations(): HasMany
    {
        return $this->hasMany(Cotization::class);
    }


}
