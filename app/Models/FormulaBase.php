<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormulaBase extends Model
{
    public $timestamps = false;

    protected $table = 'formulaBase';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idBase',
        'idFamilia',
        'porcentaje',
    ];
}
