<?php

namespace App\Http\Controllers;

use App\Http\Requests\VentaRequest;
use App\Models\Historial;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $ventas = Venta::with('carritos.producto')->paginate();

        return view('ventas.historial', compact('ventas'));
    }

    public function store(VentaRequest $request): RedirectResponse
    {
        $cliente = $request->input('cliente');
        $fecha = $request->input('fecha');
        $carrito = json_decode($request->input('carrito'), true);

        try {
            DB::beginTransaction();

            // Crear la venta
            $venta = Venta::create([
                'cliente' => $cliente,
                'fecha' => $fecha,
            ]);

            // Procesar cada producto del carrito
            foreach ($carrito as $item) {
                $idProducto = $item['idProducto'];
                $cantidad = $item['cantidad'];

                $historial = Historial::where('idProducto', $idProducto)
                    ->orderBy('fechaElaboracion', 'asc')
                    ->get();

                foreach ($historial as $lote) {
                    if ($cantidad <= 0) {
                        break;
                    }
                    if ($lote->stockActual > $cantidad) {
                        $lote->stockActual -= $cantidad;
                        $lote->save();
                        $cantidad = 0;
                    } else {
                        $cantidad -= $lote->stockActual;
                        $lote->stockActual = 0;
                        $lote->save();
                    }
                }
                if ($cantidad > 0) {
                    throw new \Exception('No hay suficiente stock para completar la venta.');
                }

                // Guardar en carritos
                DB::table('carritos')->insert([
                    'idVenta' => $venta->idVenta,
                    'idProducto' => $idProducto,
                    'cantidad' => $item['cantidad'],
                ]);
            }

            DB::commit();

            $resultado = redirect()->route('ventas.index')->with('success', 'Venta realizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            $resultado = redirect()->route('ventas.index')->with('error', $e->getMessage());
        }

        return $resultado;
    }
}
