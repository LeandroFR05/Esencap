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

    //Cada lote está relacionado con su insumo correspondiente
    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'idInsumo');
    }

    protected $fillable = [
        'numeroLote',
        'idInsumo',
        'stock', 
        'fechaVencimiento'
    ];
}
