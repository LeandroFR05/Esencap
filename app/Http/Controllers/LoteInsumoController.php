<?php

namespace App\Http\Controllers;

use App\Models\LoteInsumo;
use Illuminate\Http\Request;

class LoteInsumoController extends Controller
{
    public function showLotes($insumoId){
        $lote = LoteInsumo::where('idInsumo', $insumoId)->get();
        return view('lotes.show', compact('lote'));
    }
}
