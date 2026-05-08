<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use App\Models\Insumo;

class LoteInsumo extends Model
{
    use HasFactory;

    protected $table = 'loteinsumos';
    protected $primaryKey = 'idLote';
    public $timestamps = false;

    //Para mostrar la fecha en formato argentino
    public function getFechaVencimientoAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getFechaCompraAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    protected $fillable = [
        'numeroLote',
        'idInsumo',
        'stockInicial',
        'stockActual', 
        'fechaVencimiento',
        'fechaCompra'
    ];


    //Relaciones
    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'idInsumo');
    }
}
