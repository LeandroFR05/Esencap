<?php

namespace App\Http\Controllers;

use App\Models\Historial;

class HistorialController extends Controller
{
    public function historial()
    {
        $historial = Historial::with([
            'producto',
            'formulas.insumo',
            'formulas.familia'
        ])->paginate();
        return view('historial.general', compact('historial'));
    }
}
