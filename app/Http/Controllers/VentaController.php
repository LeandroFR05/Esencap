<?php

namespace App\Http\Controllers;

use App\Http\Requests\VentaRequest;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Venta;
use App\Services\ProductoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class VentaController extends Controller
{
    public function __construct(
        private ProductoService $productoService
    ) {}


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

        if ($request->input('orden') === 'reciente') {
            $query->orderBy('fecha', 'desc');
        } elseif ($request->input('orden') === 'antigua') {
            $query->orderBy('fecha', 'asc');
        }

        $ventas = $query->paginate(10)->appends($request->query());

        return view('ventas.historial', compact('ventas'));
    }


    public function store(VentaRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $carrito = json_decode($request->input('carrito'), true);
            $resultado = $this->productoService->descontarStockLotes($carrito);

            // Si la función devuelve un array con la clave 'producto', es un error de stock.
            if ($resultado !== null) {
                DB::rollBack();

                return redirect()->route('ventas.index')
                    ->with('stock_error_producto', $resultado)
                    ->withInput();
            }

            $venta = $this->crearVenta($request);
            $this->crearDetalleVenta($venta, $carrito);

            DB::commit();
            return redirect()->route('ventas.index')->with('success', 'Venta realizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('ventas.index')->with('error', $e->getMessage())->withInput();
        }
    }


    private function crearVenta(Request $request): Venta
    {
        return Venta::create([
            'cliente' => $request->input('cliente'),
            'fecha' => $request->input('fecha'),
            'idUsuario' => auth()->id(),
        ]);
    }

    private function crearDetalleVenta(Venta $venta, array $carrito): void
    {
        foreach ($carrito as $item) {
            DetalleVenta::create([
                'idVenta' => $venta->idVenta,
                'idProducto' => $item['idProducto'],
                'cantidad' => $item['cantidad'],
                'precioUnitario' => $item['precioUnitario'],
            ]);
        }
    }
}
