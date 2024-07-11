<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeyMovement extends Model
{
    use HasFactory;
    protected $table='key_movements';
    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'name_spanish',
        'short_spanish',
        'name_english',
        'short_english',
        'used_to',
        'type'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
