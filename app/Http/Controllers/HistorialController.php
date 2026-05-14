<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function historial(Request $request)
    {
        $query = Historial::with([
            'producto',
            'formulas.insumo',
            'formulas.familia',
        ])->withTrashed();

        // Filtro por producto
        if ($request->filled('producto')) {
            $query->whereHas('producto', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->producto . '%');
            });
        }

        // Filtro por fecha
        if ($request->filled('fecha')) {
            $query->whereDate('fechaElaboracion', $request->fecha);
        }

        $historial = $query->paginate(10)->appends($request->query());

        return view('productos.historial', compact('historial'));
    }


    public function eliminar(Historial $historial, Request $request)
    {
        $historial->estado = false; 
        $historial->save(); 
        $historial->delete();

        $redirectTo = url()->previous() ?: route('productos.lotes', $request->input('idProducto'));

        return redirect($redirectTo)->with('success', 'Registro eliminado del historial.');
    }
}
