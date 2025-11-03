<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LoteInsumo extends Model
{
    protected $table = 'loteinsumos';
    public $timestamps = false;

    //Para mostrar la fecha en formato argentino
    public function getFechaVencimientoAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    protected $fillable = [
        'numeroLote',
        'idInsumo',
        'stock', 
        'fechaVencimiento'
    ];
}
