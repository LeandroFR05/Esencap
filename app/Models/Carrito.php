<?php

namespace App\Models;

use App\Models\Venta;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    public $timestamps = false;
    protected $table = 'carritos';
    
    protected $primaryKey = 'idCarrito';
    protected $fillable = [
        'idVenta',
        'idProducto',
        'cantidad'
    ];


    //Relaciones
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'idVenta', 'idVenta');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto', 'idProducto');
    }
}
