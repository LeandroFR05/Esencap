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
            'formulas.familia'
        ])->paginate();
        return view('historial.general', compact('historial'));
    }

    public function eliminar(Request $request, Historial $historial) {
        $historial->delete();

        // Redirigir a la página anterior (última vista) si está disponible,
        // o en su defecto a la ruta de listar lotes.
        $redirectTo = url()->previous() ?: route('productos.historial', $request->input('idProducto'));

        return redirect($redirectTo)->with('success', 'Historial eliminado exitosamente.');
    }
}
