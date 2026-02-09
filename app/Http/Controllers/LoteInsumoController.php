<?php

namespace App\Http\Controllers;

use App\Models\LoteInsumo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LoteInsumoController extends Controller
{
    public function showLotes($insumoId): View {
        $lote = LoteInsumo::where('idInsumo', $insumoId)->get();
        return view('lotes.show', compact('lote'));
    }


    public function vencidos() {
        $hoy = date('Y-m-d');
        $lotesVencidos = LoteInsumo::where('fechaVencimiento', '<=', date('Y-m-d', strtotime($hoy . ' +30 days')))
            ->where('stock', '>', 0)->get();
        $lotesAgrupados = $lotesVencidos->groupBy('idInsumo');

        $bandera = 0;
        if ($lotesAgrupados->isEmpty()) {
            $bandera = 1;
        }

        return view('lotes.vencimientos', compact('lotesAgrupados', 'bandera'));
    }


    public function infoStock() {
        $lotesBajoStock = LoteInsumo::where('stock', '<=', 5)->get();
        $lotesAgrupados = $lotesBajoStock->groupBy('idInsumo');

        $bandera = 0;
        if ($lotesAgrupados->isEmpty()) {
            $bandera = 2;
        }

        return view('lotes.stock', compact('lotesAgrupados', 'bandera'));
    }
}
