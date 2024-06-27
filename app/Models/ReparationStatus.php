<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReparationStatus extends Model
{
    use HasFactory;

    protected $table = 'reparation_statuses';
    public $timestamps = false;

    protected $fillable = [
        'spanish',
        'english'
    ];


}
