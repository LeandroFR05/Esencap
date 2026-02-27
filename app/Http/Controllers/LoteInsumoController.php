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
        $lotesVencidos = LoteInsumo::where('fechaVencimiento', '<=', date('Y-m-d', strtotime($hoy . ' +30 days')))
            ->where('stockActual', '>', 0)->get();
        $lotesAgrupados = $lotesVencidos->groupBy('idInsumo');

        $bandera = 0;
        if ($lotesAgrupados->isEmpty()) {
            $bandera = 1;
        }

        return view('lotes.vencimientos', compact('lotesAgrupados', 'bandera'));
    }


    public function infoStock() {
        $lotesBajoStock = LoteInsumo::where('stockActual', '<=', 5)->get();
        $lotesAgrupados = $lotesBajoStock->groupBy('idInsumo');

        $bandera = 0;
        if ($lotesAgrupados->isEmpty()) {
            $bandera = 2;
        }

        return view('lotes.stock', compact('lotesAgrupados', 'bandera'));
    }


    public function eliminar(Request $request, LoteInsumo $lote) {
        $lote->delete();
        $idInsumo = $request->input('idInsumo');
        return redirect()->route('lotes.show', $idInsumo)->with('success', 'Lote eliminado exitosamente.');
    }
}
