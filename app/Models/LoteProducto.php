<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Formula;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoteProducto extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $table = 'loteproductos';
    protected $primaryKey = 'idLote';
    protected $fillable = [
        'numeroLote',
        'idUsuario',
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
        return $this->hasMany(Formula::class, 'idLote', 'idLote');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto', 'idProducto')->withTrashed();
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario', 'id');
    }
}
