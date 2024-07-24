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
        'spanish',
        'short_spanish',
        'name_english',
        'english',
        'used_to',
        'type',
        'require_cost',
        'user_id'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    
}
