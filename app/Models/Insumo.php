<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'idInsumo';

    protected $fillable = [
        'nombre', 
        'fase', 
        'contenidoPorUnidad',
        'idFamilia'
    ];
}
