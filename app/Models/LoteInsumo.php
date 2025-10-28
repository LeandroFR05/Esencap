<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoteInsumo extends Model
{
    protected $table = 'loteinsumos';
    public $timestamps = false;

    protected $fillable = [
        'numeroLote',
        'idInsumo',
        'stock', 
        'fechaVencimiento'
    ];
}
