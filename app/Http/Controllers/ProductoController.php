<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\Familia;
use App\Models\Formula;
use App\Models\LoteProducto;
use App\Models\Insumo;
use App\Models\LoteInsumo;
use App\Models\Producto;
use App\Services\ImageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function productos(Request $request): View
    {
        $productos = Producto::withSum('lotes', 'stockActual')
            ->withMax('lotes', 'fechaElaboracion')
            ->when($request->filled('ordenarFecha'), function ($query) use ($request) {
                $direccion = $request->ordenarFecha === 'reciente' ? 'desc' : 'asc';
                $query->orderBy('lotes_max_fechaElaboracion', $direccion);
            })
            ->paginate(10)
            ->appends($request->query());

        return view('productos.estante', compact('productos'));
    }

    public function create(): View
    {
        // Consultamos las familias y los insumos por familia para repoblar la fórmula cuando hay errores.
        $familias = Familia::all();
        $insumos = Insumo::all()->groupBy('idFamilia');

        return view('productos.create', compact('familias', 'insumos'));
    }

    public function store(ProductoRequest $request, ImageService $images): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $items = $this->mapearInsumos($request);
            $error = $this->descontarStockLotes($items);

            if ($error !== null) {
                DB::rollBack();
                return redirect()->route('productos.create')
                    ->with('stock_error', json_encode($error))
                    ->withInput();
            }

            $fotoPath = $this->guardarFoto($request, $images);
            $producto = $this->crearProducto($request, $fotoPath);
            $lote = $this->crearLote($producto, $request);
            $this->crearFormulas($lote, $request);

            DB::commit();
            return redirect()->route('productos.estante')->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('productos.create')->with(['error' => $e->getMessage()])->withInput();
        }
    }

    /* =============================
        MÉTODOS PRIVADOS DE "STORE"
    ============================= */

    // Ubica el insumo y su contenido en pares dentro de un array asociativo
    private function mapearInsumos(Request $request): array
    {
        $items = [];

        foreach ($request->insumo as $index => $insumo) {
            $items[] = [
                'idInsumo' => $insumo,
                'contenido' => (float) $request->contenido[$index],
            ];
        }

        return $items;
    }

    // Descuenta el stock de los lotes con el array que armamos anteriormente, si no hay suficiente stock retorna un array con la info del error
    private function descontarStockLotes(array $items): ?array
    {
        foreach ($items as $item) {
            $idInsumo = $item['idInsumo'];
            $contenidoNecesario = $item['contenido'];

            $insumo = Insumo::find($idInsumo);
            $unidad = $insumo->unidadDeMedida;

            $lotes = LoteInsumo::where('idInsumo', $idInsumo)
                ->orderBy('fechaVencimiento', 'asc')
                ->get();

            $lotesDetalle = $lotes->map(function ($lote) use ($unidad) {
                return [
                    'numeroLote' => $lote->numeroLote,
                    'fechaCompra' => $lote->fechaCompra,
                    'stockActual' => $lote->stockActual,
                    'fechaVencimiento' => $lote->fechaVencimiento,
                    'unidadMedida' => $unidad,
                ];
            })->toArray();

            foreach ($lotes as $lote) {
                if ($contenidoNecesario <= 0) {
                    break;
                }
                if ($lote->stockActual <= 0 || $lote->fechaVencimiento < now()) {
                    continue; // Saltar lotes vencidos o sin stock
                }

                $contenidoDisponible = $this->convertirUnidad($lote->stockActual, $unidad);

                if ($contenidoDisponible >= $contenidoNecesario) {
                    $contenidoDisponible -= $contenidoNecesario;
                    $lote->stockActual = ($contenidoDisponible * $lote->stockActual) / $this->convertirUnidad($lote->stockActual, $unidad);
                    $lote->save();
                    $contenidoNecesario = 0;
                } else {
                    $contenidoNecesario -= $contenidoDisponible;
                    $lote->stockActual = 0;
                    $lote->save();
                }
            }

            if ($contenidoNecesario > 0) {
                $nombreInsumo = $insumo->nombre;
                $stockFaltante = $contenidoNecesario;

                return [
                    'insumo' => $nombreInsumo,
                    'unidad' => $unidad,
                    'necesario' => round($stockFaltante, 2),
                    'lotes' => $lotesDetalle,
                ];
            }
        }

        return null;
    }

    private function convertirUnidad(float $valor, string $unidad): float
    {
        switch (strtolower($unidad)) {
            case 'kilos':
                return $valor * 1000; // convertir a gramos
            case 'gramos':
                return $valor; // ya está en gramos
            case 'litros':
                return $valor * 1000;
            default:
                return $valor; // fallback
        }
    }

    // Con las siguientes funciones guardamos el nuevo producto y sus relaciones
    private function guardarFoto(Request $request, ImageService $images): ?string
    {
        if ($request->hasFile('foto')) {
            return $images->storeAsWebp($request->file('foto'));
        }

        return null;
    }

    private function crearProducto(Request $request, ?string $fotoPath): Producto
    {
        return Producto::create([
            'nombre' => $request->nombre,
            'foto' => $fotoPath,
            'contenidoPorUnidad' => $request->contenidoPorUnidad,
        ]);
    }

    private function crearLote(Producto $producto, Request $request): LoteProducto
    {
        return LoteProducto::create([
            'idProducto' => $producto->idProducto,
            'idUsuario' => auth()->id(),
            'stockInicial' => $request->stockInicial,
            'stockActual' => $request->stockInicial,
            'fechaElaboracion' => $request->fechaElaboracion,
        ]);
    }

    private function crearFormulas(LoteProducto $lote, Request $request): void
    {
        $cantidad = count($request->porcentaje);

        // Recorremos los arrays para crear las fórmulas
        for ($i = 0; $i < $cantidad; $i++) {
            Formula::create([
                'idLote' => $lote->idLote,
                'idFamilia' => $request->familia[$i],
                'porcentaje' => $request->porcentaje[$i],
                'idInsumo' => $request->insumo[$i],
                'contenido' => $request->contenido[$i],
            ]);
        }
    }

    /* =============================
        FIN MÉTODOS PRIVADOS DE "STORE"
    ============================= */

    public function edit(Producto $producto): View
    {
        $stockTotal = LoteProducto::where('idProducto', $producto->idProducto)->sum('stockActual');
        $ultimaElaboracion = LoteProducto::where('idProducto', $producto->idProducto)
        ->latest('fechaElaboracion')
        ->value('fechaElaboracion');

        return view('productos.edit', compact('producto', 'stockTotal', 'ultimaElaboracion'));
    }


    public function update(ProductoRequest $request, Producto $producto, ImageService $images)
    {
        $validated = $request->validated();

        // Para verificar si se eliminó la foto en el formulario, y no se volvió a cargar otra
        if ($request->remove_foto == '1') {
            if ($producto->foto) {
                Storage::disk('public')->delete($producto->foto);
            }
            $producto->foto = null;
        }

        if ($request->hasFile('foto')) {
            if ($producto->foto && Storage::disk('public')->exists($producto->foto)) {
                Storage::disk('public')->delete($producto->foto); // Eliminar la foto antigua
            }
            $validated['foto'] = $images->storeAsWebp($request->file('foto')); // Actualizar con la nueva foto en webp
        }

        $producto->update($validated);

        return redirect()->route('productos.edit', ['producto' => $producto->idProducto])->with('success', 'Producto actualizado exitosamente.');
    }


    public function reponer(Producto $producto): View
    {
        $familias = Familia::all();
        $lote = LoteProducto::with([
            'formulas.familia',
            'formulas.insumo',
        ])->where('idProducto', $producto->idProducto)->orderBy('fechaElaboracion', 'desc')->first();

        return view('productos.reponer', compact('producto', 'lote', 'familias'));
    }


    public function reponerStore(ProductoRequest $request, Producto $producto): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $items = $this->mapearInsumos($request);
            $resultado = $this->descontarStockLotes($items);

            if ($resultado !== null) {
                DB::rollBack();
                return redirect()->route('productos.reponer', $producto->idProducto)
                    ->with('stock_error', json_encode($resultado))
                    ->withInput();
            }

            $lote = $this->crearLote($producto, $request);
            $this->crearFormulas($lote, $request);

            DB::commit();

            $resultado = redirect()->route('productos.reponer', $producto->idProducto)->with('success', 'Producto repuesto exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            $resultado = redirect()->route('productos.reponer', $producto->idProducto)->with(['error' => $e->getMessage()])->withInput();
        }

        return $resultado;
    }


    public function lotes(Producto $producto): View
    {
        $producto = Producto::with([
            'lotes.formulas.familia',
            'lotes.formulas.insumo',
        ])->find($producto->idProducto);

        $lote = $producto->lotes;

        return view('productos.lotes', compact('producto', 'lote'));
    }


    public function eliminar(Producto $producto): RedirectResponse {
        $producto->estado = false;
        $producto->save();
        $producto->delete();

        return redirect()->route('productos.estante')->with('success', 'Producto eliminado exitosamente.');
    }

    public function eliminados(): View {
        $productosEliminados = Producto::onlyTrashed()->get();
        return view('productos.eliminados', compact('productosEliminados'));
    }

    public function restore($idProducto): RedirectResponse {
        $producto = Producto::onlyTrashed()->findOrFail($idProducto);
        $producto->restore();
        $producto->estado = true;
        $producto->save();

        return redirect()->route('productos.eliminados')->with('success', 'Producto restaurado exitosamente.');
    }
}
