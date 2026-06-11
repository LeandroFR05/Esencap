<?php

namespace App\Http\Controllers;

use App\Http\Requests\VentaRequest;
use App\Models\LoteProducto;
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

    public function historial(Request $request): View
    {
        $query = Venta::with('detalleVentas.producto');

        if ($request->filled('cliente')) {
            $query->where('cliente', 'like', '%' . $request->cliente . '%');
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        $ventas = $query->paginate(10)->appends($request->query());

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
                'idUsuario' => auth()->id(),
            ]);

            // Procesar cada producto del carrito
            foreach ($carrito as $item) {
                $idProducto = $item['idProducto'];
                $cantidad = $item['cantidad'];

                $producto = Producto::find($idProducto);
                $nombreProducto = $producto->nombre;

                $lotes = LoteProducto::where('idProducto', $idProducto)
                    ->orderBy('fechaElaboracion', 'asc')
                    ->get();

                foreach ($lotes as $lote) {
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
                    throw new \Exception("No hay suficiente stock de " . $nombreProducto . " para completar la venta.");
                }

                // Guardar en detalleVentas
                DB::table('detalleVentas')->insert([
                    'idVenta' => $venta->idVenta,
                    'idProducto' => $idProducto,
                    'cantidad' => $item['cantidad'],
                    'precioUnitario' => $item['precioUnitario'],
                ]);
            }

            DB::commit();

            $resultado = redirect()->route('ventas.index')->with('success', 'Venta realizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            $resultado = redirect()->route('ventas.index')
                ->with('error', $e->getMessage())
                ->withInput()
                ->with('carrito', $carrito);
        }

        return $resultado;
    }
}
