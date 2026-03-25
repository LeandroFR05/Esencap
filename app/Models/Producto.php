<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Historial;
use App\Models\Carrito;

class Producto extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'idProducto';

    
    //Campos editables
    protected $fillable = [
        'nombre',
        'foto', 
        'contenidoPorUnidad'
    ];


    //Relaciones
    public function historiales()
    {
        return $this->hasMany(Historial::class, 'idProducto', 'idProducto');
    }

    public function carritos()
    {
        return $this->hasMany(Carrito::class, 'idProducto', 'idProducto');
    }


}
