<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Insumo;
use App\Models\Formula;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Familia extends Model
{
    use HasFactory;
    
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
