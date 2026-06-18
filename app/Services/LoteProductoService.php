<?php

namespace App\Services;

use App\Models\LoteProducto;
use App\Models\Producto;
use Illuminate\Http\Request;

class LoteProductoService
{
    public function crearLote(Producto $producto, Request $request): LoteProducto
    {
        return LoteProducto::create([
            'idProducto' => $producto->idProducto,
            'idUsuario' => auth()->id(),
            'stockInicial' => $request->stockInicial,
            'stockActual' => $request->stockInicial,
            'fechaElaboracion' => $request->fechaElaboracion,
        ]);
    }
}
?>