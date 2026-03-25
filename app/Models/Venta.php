<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    public $timestamps = false;

    protected $table = 'ventas';

    protected $primaryKey = 'idVenta';

    protected $fillable = [
        'fecha',
        'cliente',
    ];

    public function getFechaAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    // Relaciones
    public function carritos()
    {
        return $this->hasMany(Carrito::class, 'idVenta', 'idVenta');
    }
}
