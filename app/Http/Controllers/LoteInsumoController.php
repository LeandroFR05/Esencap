<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\LoteInsumo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LoteInsumoController extends Controller
{
    public function vencidos()
    {
        $hoy = now();
        $limite = $hoy->copy()->addDays(10)->toDateString();

        // Obtenemos los idInsumo distintos que tienen lotes próximos a vencer
        $idInsumos = LoteInsumo::where('fechaVencimiento', '<=', $limite)
            ->distinct()
            ->pluck('idInsumo');

        // Paginamos sobre los insumos que realmente tienen lotes
        $insumos = Insumo::where('estado', 1)
            ->whereIn('idInsumo', $idInsumos)
            ->paginate(5);

        // Agrupamos solo los lotes de los insumos de la página actual
        $lotesAgrupados = collect();

        foreach ($insumos as $insumo) {
            $lotes = LoteInsumo::where('idInsumo', $insumo->idInsumo)
                ->where('fechaVencimiento', '<=', $limite)
                ->get();

            if ($lotes->isNotEmpty()) {
                $lotesAgrupados[$insumo->idInsumo] = $lotes;
            }
        }

        $bandera = $lotesAgrupados->isEmpty() ? 1 : 0;

        return view('lotes.vencimientos', compact('lotesAgrupados', 'bandera', 'insumos'));
    }


    public function infoStock()
    {
        // Filtramos los insumos que tienen al menos un lote con bajo stock
        $insumos = Insumo::where('estado', 1)
            ->whereHas('lotes', function ($query) {
                $query->where(function ($q) {
                    $q->where(function ($q2) {
                        $q2->whereRaw("unidadDeMedida = 'gramos'")
                            ->where('stockActual', '<', 500);
                    })->orWhere(function ($q2) {
                        $q2->whereRaw("unidadDeMedida = 'kilos'")
                            ->where('stockActual', '<', 1);
                    })->orWhere(function ($q2) {
                        $q2->whereRaw("unidadDeMedida = 'unidades'")
                            ->where('stockActual', '<', 10);
                    })->orWhere(function ($q2) {
                        $q2->whereRaw("unidadDeMedida = 'litros'")
                            ->where('stockActual', '<', 2);
                    });
                });
            })
            ->paginate(5);

        // Agrupamos los lotes de los insumos de la página actual
        $lotesAgrupados = collect();

        foreach ($insumos as $insumo) {
            $stockMinimo = match (strtolower($insumo->unidadDeMedida)) {
                'gramos'   => 500,
                'kilos'    => 1,
                'unidades' => 10,
                'litros'   => 2,
            };

            $lotes = LoteInsumo::where('idInsumo', $insumo->idInsumo)
                ->where('stockActual', '<', $stockMinimo)
                ->get();

            if ($lotes->isNotEmpty()) {
                $lotesAgrupados[$insumo->idInsumo] = $lotes;
            }
        }

        $bandera = $lotesAgrupados->isEmpty() ? 2 : 0;

        return view('lotes.stock', compact('lotesAgrupados', 'bandera', 'insumos'));
    }


    public function eliminar(Request $request, LoteInsumo $lote)
    {
        $lote->estado = false;
        $lote->save();
        $lote->delete();

        $redirectTo = url()->previous() ?: route('insumos.lotes', $request->input('idInsumo'));

        return redirect($redirectTo)->with('success', 'Lote eliminado exitosamente.');
    }
}
