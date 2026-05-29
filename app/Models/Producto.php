<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LoteProducto;
use App\Models\Carrito;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    protected $primaryKey = 'idProducto';

    
    //Campos editables
    protected $fillable = [
        'nombre',
        'foto', 
        'contenidoPorUnidad'
    ];


    //Relaciones
    public function lotes()
    {
        return $this->hasMany(LoteProducto::class, 'idProducto', 'idProducto');
    }

    public function carritos()
    {
        return $this->hasMany(Carrito::class, 'idProducto', 'idProducto');
    }


}
