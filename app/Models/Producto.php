<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LoteProducto;
use App\Models\DetalleVenta;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    protected $primaryKey = 'idProducto';
    

    // Soft delete en cascada para los lotes asociados al producto
    protected static function booted()
    {
        static::deleting(function (Producto $producto) {
            $producto->lotes()->update(['estado' => false]);
            $producto->lotes()->delete();
        });

        static::restoring(function (Producto $producto) {
            $lotes = $producto->lotes()->withTrashed();
            $lotes->update(['estado' => true]);
            $lotes->restore();
        });
    }

    

    
    //Campos editables
    protected $fillable = [
        'nombre',
        'foto', 
        'contenidoPorUnidad'
    ];


    //Relaciones
    public function lotes()
    {
        return $this->hasMany(LoteProducto::class, 'idProducto', 'idProducto');
    }

    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class, 'idProducto', 'idProducto');
    }
}
