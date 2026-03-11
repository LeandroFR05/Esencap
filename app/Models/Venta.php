<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use Carbon\Carbon;

class Venta extends Model
{
    public $timestamps = false;
    protected $table = 'ventas';
    
    protected $primaryKey = 'idVenta';
    protected $fillable = [
        'idProducto',
        'cantidad',
        'fecha',
        'cliente'
    ];


    public function getFechaAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }


    //Relaciones
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto', 'idProducto');
    }
}
