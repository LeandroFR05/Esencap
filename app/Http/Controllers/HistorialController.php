<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function historial()
    {
        $historial = Historial::with([
            'producto',
            'formulas.insumo',
            'formulas.familia',
        ])->paginate(10);

        return view('historial.productos', compact('historial'));
    }

    public function eliminar(Request $request, Historial $historial)
    {
        $historial->delete();

        $redirectTo = url()->previous() ?: route('productos.historial', $request->input('idProducto'));

        return redirect($redirectTo)->with('success', 'Historial eliminado exitosamente.');
    }
}
