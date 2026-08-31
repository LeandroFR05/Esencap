<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoteProducto;

class LoteProductoController extends Controller
{
    public function historial(Request $request)
    {
        $query = LoteProducto::withTrashed()->with([
            'producto',
        ]);

        // Filtro por estado
        if ($request->estado === 'Activo') {
            $query->where('lote_productos.estado', true);
        }
        if ($request->estado === 'Eliminado') {
            $query->where('lote_productos.estado', false);
        }

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

        if ($request->input('orden') === 'reciente') {
            $query->orderBy('fechaElaboracion', 'desc');
        } elseif ($request->input('orden') === 'antigua') {
            $query->orderBy('fechaElaboracion', 'asc');
        }

        $historial = $query->paginate(10)->appends($request->query());

        return view('productos.historial', compact('historial'));
    }


    public function eliminar(Request $request, LoteProducto $lote)
    {
        $lote->estado = false;
        $lote->save();
        $lote->delete();

        $redirectTo = url()->previous() ?: route('productos.lotes', $request->input('idProducto'));

        return redirect($redirectTo)->with('success', 'Registro eliminado del historial.');
    }
}
