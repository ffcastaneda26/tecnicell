<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizationStatus extends Model
{
    use HasFactory;
    protected $table = 'cotization_statuses';
    public $timestamps = false;

    protected $fillable = [
        'spanish',
        'english'
    ];


}
