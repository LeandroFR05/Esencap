<?php

namespace App\Services;

use App\Models\LoteProducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LoteProductoService
{
    public function crearLote(Producto $producto, Request $request): LoteProducto
    {
        $fechaElaboracion = Carbon::parse($request->fechaElaboracion)
            ->setTime(Carbon::now()->hour, Carbon::now()->minute, Carbon::now()->second);

        return LoteProducto::create([
            'idProducto' => $producto->idProducto,
            'idUsuario' => auth()->id(),
            'stockInicial' => $request->stockInicial,
            'stockActual' => $request->stockInicial,
            'fechaElaboracion' => $fechaElaboracion->format('Y-m-d H:i:s'),
        ]);
    }
}
?>