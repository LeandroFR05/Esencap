<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Familia;
use App\Models\Formula;
use App\Models\LoteInsumo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insumo extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    protected $primaryKey = 'idInsumo';

    protected $fillable = [
        'nombre',
        'foto', 
        'fase',
        'idFamilia',
        'unidadDeMedida'
    ];


    //Relaciones
    public function lotes()
    {
        return $this->hasMany(LoteInsumo::class, 'idInsumo', 'idInsumo');
    }

    public function familia()
    {
        return $this->belongsTo(Familia::class, 'idFamilia', 'idFamilia');
    }

    public function formulas()
    {
        return $this->hasMany(Formula::class, 'idInsumo', 'idInsumo');
    }
}
