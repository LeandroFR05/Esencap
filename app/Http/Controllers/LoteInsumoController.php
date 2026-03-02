<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\LoteInsumo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LoteInsumoController extends Controller
{
    public function showLotes($insumoId): View {
        $lote = LoteInsumo::where('idInsumo', $insumoId)->get();
        $insumo = Insumo::where('idInsumo', $insumoId)->first();
        return view('lotes.show', compact('lote', 'insumo'));
    }


    public function vencidos() {
        $hoy = date('Y-m-d');
        $lotesVencidos = LoteInsumo::where('fechaVencimiento', '<=', date('Y-m-d', strtotime($hoy . ' +10 days')))
            ->where('stockActual', '>', 0)->get();
        $lotesAgrupados = $lotesVencidos->groupBy('idInsumo');

        $bandera = 0;
        if ($lotesAgrupados->isEmpty()) {
            $bandera = 1;
        }

        return view('lotes.vencimientos', compact('lotesAgrupados', 'bandera'));
    }


    public function infoStock() {
        $insumos = Insumo::all();
        $lotesAgrupados = collect();

        foreach ($insumos as $insumo) {
            // Definir el stock mínimo según la unidad de medida
            $stockMinimo = match (strtolower($insumo->unidadDeMedida)) {
                'gramos'   => 500,
                'kilos'    => 1,
                'unidades' => 10,
                'litros'   => 1,
                default    => 5,
            };

            // Buscar lotes de ese insumo con stock bajo
            $lotes = LoteInsumo::where('idInsumo', $insumo->idInsumo)
                ->where('stockActual', '<=', $stockMinimo)
                ->get();

            if ($lotes->isNotEmpty()) {
                $lotesAgrupados[$insumo->idInsumo] = $lotes;
            }
        }

        $bandera = $lotesAgrupados->isEmpty() ? 2 : 0;

        return view('lotes.stock', compact('lotesAgrupados', 'bandera'));
    }


    public function eliminar(Request $request, LoteInsumo $lote) {
        $lote->delete();
        $idInsumo = $request->input('idInsumo');
        return redirect()->route('lotes.show', $idInsumo)->with('success', 'Lote eliminado exitosamente.');
    }
}
