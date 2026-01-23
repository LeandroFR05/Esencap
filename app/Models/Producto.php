<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Historial;
use App\Models\Venta;

class Producto extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'idProducto';

    
    //Campos editables
    protected $fillable = [
        'nombre',
        'foto', 
        'contenidoPorUnidad',
        'idBase',
        'idRecalculada'
    ];


    //Relaciones
    public function historiales()
    {
        return $this->hasMany(Historial::class, 'idProducto', 'idProducto');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'idProducto', 'idProducto');
    }
}
