<?php

namespace App\Models;

use App\Models\Venta;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    public $timestamps = false;
    protected $table = 'detalle_ventas';
    
    protected $primaryKey = 'idDetalle';
    protected $fillable = [
        'idVenta',
        'idProducto',
        'cantidad',
        'precioUnitario'
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
