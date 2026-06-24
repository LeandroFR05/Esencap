<?php

namespace App\Services;

use App\Models\Formula;
use App\Models\LoteProducto;
use Illuminate\Http\Request;

class FormulaService
{
    public function crearFormula(LoteProducto $lote, Request $request): void
    {
        $cantidad = count($request->porcentaje);

        // Recorremos los arrays para crear las fórmulas
        for ($i = 0; $i < $cantidad; $i++) {
            Formula::create([
                'idLote' => $lote->idLote,
                'porcentaje' => $request->porcentaje[$i],
                'idInsumo' => $request->insumo[$i],
                'contenido' => $request->contenido[$i],
            ]);
        }
    }
}
?>