<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegimenFiscal extends Model
{
    use HasFactory;
    protected $table = 'regimenes_fiscales';
    public $timestamps = false;
    protected $fillable = [
        'codigo',
        'nombre',
        'fisicas',
        'morales',
        'inicio_vigencia',
        'fin_vigencia',
        'active'
    ];

    protected function casts(): array
    {
        return [
            'inicio_vigencia' => 'datetime:Y-m-d',
            'fin_vigencia' => 'datetime:Y-m-d',
        ];
    }
}
