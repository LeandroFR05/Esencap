<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LoteProducto;
use App\Models\Familia;
use App\Models\Insumo;

class Formula extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'idFormula';
    protected $table = 'formulas';

    protected $fillable = [
        'idLote',
        'idFamilia',
        'porcentaje',
        'idInsumo',
        'contenido'
    ];


    //Relaciones
    public function lote()
    {
        return $this->belongsTo(LoteProducto::class, 'idLote', 'idLote');
    }

    public function familia()
    {
        return $this->belongsTo(Familia::class, 'idFamilia', 'idFamilia');
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'idInsumo', 'idInsumo')->withTrashed();
    }
}
