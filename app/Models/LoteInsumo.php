<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use App\Models\Insumo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoteInsumo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lote_insumos';
    protected $primaryKey = 'idLote';
    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($loteInsumo) {
            if (empty($loteInsumo->numeroLote)) {
                $maxLote = static::where('idInsumo', $loteInsumo->idInsumo)->withTrashed()->max('numeroLote');
                $loteInsumo->numeroLote = ($maxLote ?? 0) + 1;
            }
        });
    }

    protected $fillable = [
        'numeroLote',
        'idInsumo',
        'stockInicial',
        'stockActual', 
        'fechaVencimiento',
        'fechaCompra'
    ];


    // Para mostrar la fecha en formato argentino
    public function getFechaCompraAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    //Relaciones
    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'idInsumo')->withTrashed();
    }
}
