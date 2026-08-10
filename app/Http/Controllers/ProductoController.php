<?php

namespace App\Http\Controllers;

// Modelos
use App\Models\Familia;
use App\Models\LoteProducto;
use App\Models\Insumo;
use App\Models\Producto;

// Requests
use App\Http\Requests\ProductoRequest;

// Servicios
use App\Services\InsumoService;
use App\Services\ImageService;
use App\Services\LoteProductoService;
use App\Services\FormulaService;

// Otros
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function __construct(    
        private InsumoService $insumoService,
        private ImageService $imageService,
        private LoteProductoService $loteProductoService,
        private FormulaService $formulaService
    ) {}

    public function productos(Request $request): View
    {
        $productos = Producto::withSum('lotes', 'stockActual') // muestra el stock total de cada producto en la tarjeta
            ->when($request->filled('ordenarFecha'), function ($query) use ($request) {
                $direccion = $request->ordenarFecha === 'reciente' ? 'desc' : 'asc';
                $query->orderBy(
                    LoteProducto::selectRaw('MAX(lote_productos.fechaElaboracion)')
                        ->whereColumn('lote_productos.idProducto', 'productos.idProducto'),
                    $direccion // De cada producto busca el último lote elaborado
                );
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

    public function store(ProductoRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $resultado = $this->insumoService->descontarStockLotes($request);

            if ($resultado !== null) {
                DB::rollBack();
                
                return redirect()->route('productos.create')
                    ->with('stock_error_insumo', $resultado)
                    ->withInput();
            }

            $fotoPath = $this->guardarFoto($request);
            $producto = $this->crearProducto($request, $fotoPath);
            $lote = $this->loteProductoService->crearLote($producto, $request);
            $this->formulaService->crearFormula($lote, $request);
                
            DB::commit();
            return redirect()->route('productos.estante')->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('productos.create')->with(['error' => $e->getMessage()])->withInput();
        }
    }

    private function guardarFoto(Request $request): ?string
    {
        if ($request->hasFile('foto')) {
            // Todas las imágenes se guardan en formato webp. "ImageService" se encarga de convertirlas y guardarlas.
            return $this->imageService->storeAsWebp($request->file('foto'));
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


    public function edit(Producto $producto): View
    {
        $stockTotal = LoteProducto::where('idProducto', $producto->idProducto)->sum('stockActual');
        $ultimaElaboracion = LoteProducto::where('idProducto', $producto->idProducto)
        ->latest('fechaElaboracion')
        ->value('fechaElaboracion');

        return view('productos.edit', compact('producto', 'stockTotal', 'ultimaElaboracion'));
    }


    public function update(ProductoRequest $request, Producto $producto): RedirectResponse
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
            $validated['foto'] = $this->guardarFoto($request); // Actualizar con la nueva foto en webp
        }

        $producto->update($validated);

        return redirect()->route('productos.edit', ['producto' => $producto->idProducto])->with('success', 'Producto actualizado exitosamente.');
    }


    public function reponer(Producto $producto): View
    {
        $familias = Familia::all();
        $lote = LoteProducto::with([
            'formulas.insumo.familia',
            'formulas.insumo',
        ])->where('idProducto', $producto->idProducto)->orderBy('fechaElaboracion', 'desc')->first();

        return view('productos.reponer', compact('producto', 'lote', 'familias'));
    }


    public function reponerStore(ProductoRequest $request, Producto $producto): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $resultado = $this->insumoService->descontarStockLotes($request);

            if ($resultado !== null) {
                DB::rollBack();

                return redirect()->route('productos.reponer', $producto->idProducto)
                    ->with('stock_error_insumo', $resultado)
                    ->withInput();
            }

            $lote = $this->loteProductoService->crearLote($producto, $request);
            $this->formulaService->crearFormula($lote, $request);

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
