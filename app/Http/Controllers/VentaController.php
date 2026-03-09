<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Historial;
use App\Http\Requests\VentaRequest;
use App\Models\Venta;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\RedirectResponse;

class VentaController extends Controller
{
    public function ventas(): View
    {
        // Lógica para mostrar la vista de ventas
        return view('ventas.index');
    }

    public function buscar(Request $request): JsonResponse
    {
        $query = $request->get('query');

        $productos = Producto::where('nombre', 'like', "%{$query}%")
            ->limit(10)
            ->get(['idProducto', 'nombre']);

        return response()->json($productos);
    }

    public function historial(): View
    {
        return view('ventas.historial');
    }

    public function store(VentaRequest $request): RedirectResponse
    {
        $idProducto = $request->input('idProducto');
        $cantidad = $request->input('cantidad');

        try {
            $historial = Historial::where('idProducto', $idProducto)
                ->orderBy('fechaElaboracion', 'desc')
                ->get();

            foreach ($historial as $item) {
                if ($cantidad <= 0) {
                    break;
                }
                if ($item->stock > $cantidad) {
                    $item->stock -= $cantidad;
                    $item->save();
                    $cantidad = 0;
                } else {
                    $cantidad -= $item->stock;
                    $item->stock = 0;
                    $item->save();
                } 
            }
            if ($cantidad > 0) {
                throw new \Exception('No hay suficiente stock para completar la venta.');
            }

            Venta::create($request->all()); //Guardar la venta

            $resultado = redirect()->route('ventas.index')->with('success', 'Venta realizada exitosamente.');
        } catch (\Exception $e) {
            $resultado = redirect()->route('ventas.index')->with('error', $e->getMessage());
        }

        return $resultado;
    }
}
