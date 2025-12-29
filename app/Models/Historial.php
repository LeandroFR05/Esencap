<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    public $timestamps = false;

    protected $table = 'historial';
    protected $primaryKey = 'idHistorial';
    protected $fillable = [
        'idProducto',
        'stock',
        'fechaElaboracion',
        'idBase',
        'idRecalculada'
    ];
}
