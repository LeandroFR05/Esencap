<?php

namespace App\Services;

use App\Models\Producto;
use App\Models\LoteProducto;

class ProductoService
{
    public function descontarStockLotes(array $carrito): ?array
    {
        // Procesar cada producto del carrito
        foreach ($carrito as $item) {
            $idProducto = $item['idProducto'];
            $cantidad = $item['cantidad'];
            $producto = Producto::find($idProducto);
            $nombreProducto = $producto->nombre;

            $sumaStock = LoteProducto::where('idProducto', $idProducto)->sum('stockActual');

            $lotes = LoteProducto::where('idProducto', $idProducto)
                ->orderBy('fechaElaboracion', 'asc')
                ->get();

            if ($sumaStock >= $cantidad) {
                foreach ($lotes as $lote) {
                    if ($cantidad <= 0) {
                        break;
                    }
                    if ($lote->stockActual > $cantidad) {
                        $lote->stockActual -= $cantidad;
                        $lote->save();
                        $cantidad = 0;
                    } else {
                        $cantidad -= $lote->stockActual;
                        $lote->stockActual = 0;
                        $lote->save();
                    }
                }
            }
            else {
                return [
                    'producto' => $nombreProducto,
                    'idProducto' => $idProducto,
                    'stockDisponible' => round($sumaStock, 2),
                    'stockSolicitado' => $cantidad,
                    'lotes' => $lotes,
                ];
            }
        }

        return null;
    }
}

?>