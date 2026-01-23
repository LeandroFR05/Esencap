<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Historial;
use App\Models\Familia;
use App\Models\Insumo;

class Formula extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'idFormula';
    protected $table = 'formulas';

    protected $fillable = [
        'idHistorial',
        'idFamilia',
        'porcentaje',
        'idInsumo',
        'contenido'
    ];


    //Relaciones
    public function historial()
    {
        return $this->belongsTo(Historial::class, 'idHistorial', 'idHistorial');
    }

    public function familia()
    {
        return $this->belongsTo(Familia::class, 'idFamilia', 'idFamilia');
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'idInsumo', 'idInsumo');
    }
}
