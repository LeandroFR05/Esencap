<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Formula;
use Carbon\Carbon;

class Historial extends Model
{
    public $timestamps = false;

    protected $table = 'historial';
    protected $primaryKey = 'idHistorial';
    protected $fillable = [
        'numeroLote',
        'idProducto',
        'stockInicial',
        'stockActual',
        'fechaElaboracion',
    ];

    public function getFechaElaboracionAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }


    //Relaciones
    public function formulas()
    {
        return $this->hasMany(Formula::class, 'idHistorial', 'idHistorial');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto', 'idProducto')->withTrashed();
    }
}
