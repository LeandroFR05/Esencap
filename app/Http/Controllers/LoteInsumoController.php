<?php

namespace App\Http\Controllers;

use App\Models\LoteInsumo;
use Illuminate\Http\Request;

class LoteInsumoController extends Controller
{
    public function showLotes($insumoId) {
        $lote = LoteInsumo::where('idInsumo', $insumoId)->get();
        return view('lotes.show', compact('lote'));
    }


    public function vencidos() {
        $hoy = date('Y-m-d');
        $lotesVencidos = LoteInsumo::where('fechaVencimiento', '<=', date('Y-m-d', strtotime($hoy . ' +30 days')))
            ->where('stock', '>', 0)->get();
        $lotesAgrupados = $lotesVencidos->groupBy('idInsumo');

        return view('lotes.vencimientos', [
            'lotesAgrupados' => $lotesAgrupados
        ]);
    }


    public function infoStock() {
        $lotesBajoStock = LoteInsumo::where('stock', '<=', 5)->get();
        $lotesAgrupados = $lotesBajoStock->groupBy('idInsumo');

        return view('lotes.stock', [
            'lotesAgrupados' => $lotesAgrupados
        ]);
    }
}
