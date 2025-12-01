<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormulaRecalculada extends Model
{
    public $timestamps = false;

    protected $table = 'formulaRecalculada';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idRecalculada',
        'idInsumo',
        'contenido',
    ];
}
