<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Insumo;
use App\Models\Formula;

class Familia extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'idFamilia';

    protected $fillable = [
        'nombre'
    ];


    //Relaciones
    public function insumos()
    {
        return $this->hasMany(Insumo::class, 'idFamilia', 'idFamilia');
    }

    public function formulas()
    {
        return $this->hasMany(Formula::class, 'idFamilia', 'idFamilia');
    }
}
