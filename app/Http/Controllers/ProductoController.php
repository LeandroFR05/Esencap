<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\Familia;
use App\Models\Formula;
use App\Models\Historial;
use App\Models\Insumo;
use App\Models\LoteInsumo;
use App\Models\Producto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function productos(): View
    {
        $productos = Producto::withSum('historiales', 'stockActual')->paginate(10);

        return view('productos.estante', compact('productos'));
    }

    public function create(): View
    {
        // Consultamos las familias, porque vamos a necesitar para la fórmula base del producto
        $familias = Familia::all();

        return view('productos.create', compact('familias'));
    }

    public function store(ProductoRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Con estas funciones comprobamos de que haya suficiente stock de los insumos, y los descontamos en los lotes
            $items = $this->mapearInsumos($request);

            $this->descontarStockLotes($items);

            // Si está todo correcto, procedemos a crear el producto y sus relaciones
            $fotoPath = $this->guardarFoto($request);
            $producto = $this->crearProducto($request, $fotoPath);
            $historial = $this->crearHistorial($producto, $request);
            $this->crearFormulas($historial, $request);

            DB::commit();

            $resultado = redirect()->route('productos.estante')->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            $resultado = redirect()->route('productos.create')->with(['error' => $e->getMessage()])->withInput();
        }

        return $resultado;
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

    // Descuenta el stock de los lotes con el array que armamos anteriormente, si no hay suficiente stock lanza una excepción
    private function descontarStockLotes(array $items): void
    {
        foreach ($items as $item) {
            $idInsumo = $item['idInsumo'];
            $contenidoNecesario = $item['contenido'];

            // Traemos el insumo para conocer su unidad de medida
            $insumo = Insumo::find($idInsumo);
            $unidad = $insumo->unidadDeMedida;

            // Convertimos el contenidoNecesario a la unidad base según el insumo
            $contenidoNecesario = $this->convertirUnidad($contenidoNecesario, $unidad);

            // Buscamos lotes que coincidan con el insumo y que tengan stock disponible con fecha de vencimiento más cercana
            $lotes = LoteInsumo::where('idInsumo', $idInsumo)
                ->where('stockActual', '>', 0)
                ->orderBy('fechaVencimiento', 'asc')
                ->get();

            // Recorremos los lotes para descontar el stock necesario
            foreach ($lotes as $lote) {
                // Si el contenidoNecesario es <= 0, significa que ya se usó para restar el stock, entonces termina el bucle
                if ($contenidoNecesario <= 0) {
                    break;
                }

                // Verificar si la fecha de vencimiento ya pasó, si es así, saltar este lote
                if (\Carbon\Carbon::parse($lote->fechaVencimiento)->isPast()) {
                    continue;
                }

                if ($lote->stockActual >= $contenidoNecesario) {
                    $lote->stockActual -= $contenidoNecesario;
                    $lote->save();
                    $contenidoNecesario = 0;
                } else {
                    $contenidoNecesario -= $lote->stockActual;
                    $lote->stockActual = 0;
                    $lote->save();
                }
            }
            
            // Si aún falta contenido después de recorrer todos los lotes
            if ($contenidoNecesario > 0) {
                $nombreInsumo = Insumo::find($idInsumo)->nombre;
                
                // Recolectamos información de lotes vencidos y disponibles
                $loteVencidos = $lotes->filter(function ($lote) {
                    return \Carbon\Carbon::parse($lote->fechaVencimiento)->isPast();
                })->pluck('numeroLote')->toArray();
                
                if (!empty($loteVencidos)) {
                    $mensaje = "El insumo {$nombreInsumo} tiene los siguientes lotes vencidos: " . implode(', ', $loteVencidos) . ".";
                }
                else{
                    $mensaje = "El insumo {$nombreInsumo} no tiene stock suficiente.";
                }
                
                throw new \Exception($mensaje);
            }
        }
    }

    private function convertirUnidad(float $valor, string $unidad): float
    {
        switch (strtolower($unidad)) {
            case 'kilos':
                return $valor / 1000; // convertir a gramos
            case 'gramos':
                return $valor; // ya está en gramos
            case 'litros':
                return $valor / 1000;
            default:
                return $valor; // fallback
        }
    }

    // Con las siguientes funciones guardamos el nuevo producto y sus relaciones
    private function guardarFoto(Request $request): ?string
    {
        if ($request->hasFile('foto')) {
            return $request->file('foto')->store('uploads', 'public');
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

    private function crearHistorial(Producto $producto, Request $request): Historial
    {
        return Historial::create([
            'idProducto' => $producto->idProducto,
            'stockInicial' => $request->stockInicial,
            'stockActual' => $request->stockInicial,
            'fechaElaboracion' => $request->fechaElaboracion,
        ]);
    }

    private function crearFormulas(Historial $historial, Request $request): void
    {
        $cantidad = count($request->porcentaje);

        // Recorremos los arrays para crear las fórmulas
        for ($i = 0; $i < $cantidad; $i++) {
            Formula::create([
                'idHistorial' => $historial->idHistorial,
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
        $stockTotal = Historial::where('idProducto', $producto->idProducto)->sum('stockActual');
        $ultimaElaboracion = Historial::where('idProducto', $producto->idProducto)
        ->latest('fechaElaboracion')
        ->value('fechaElaboracion');

        return view('productos.edit', compact('producto', 'stockTotal', 'ultimaElaboracion'));
    }


    public function update(ProductoRequest $request, Producto $producto)
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
            $fotoPath = $request->file('foto')->store('uploads', 'public');
            $validated['foto'] = $fotoPath; // Actualizar con la nueva foto
        }

        $producto->update($validated);

        return redirect()->route('productos.edit', ['producto' => $producto->idProducto])->with('success', 'Producto actualizado exitosamente.');
    }


    public function reponer(Producto $producto): View
    {
        $familias = Familia::all();
        $historial = Historial::with([
            'formulas.familia',
            'formulas.insumo',
        ])->where('idProducto', $producto->idProducto)->orderBy('fechaElaboracion', 'desc')->first();

        return view('productos.reponer', compact('producto', 'historial', 'familias'));
    }


    public function reponerStore(ProductoRequest $request, Producto $producto): RedirectResponse
    {
        try {
            // Con estas funciones comprobamos de que haya suficiente stock de los insumos, y los descontamos en los lotes
            $items = $this->mapearInsumos($request);
            $this->descontarStockLotes($items);

            // Si está todo correcto, procedemos a crear el historial y sus relaciones
            $historial = $this->crearHistorial($producto, $request);
            $this->crearFormulas($historial, $request);

            $resultado = redirect()->route('productos.reponer', $producto->idProducto)->with('success', 'Producto repuesto exitosamente.');
        } catch (\Exception $e) {
            $resultado = redirect()->route('productos.reponer', $producto->idProducto)->with(['error' => $e->getMessage()])->withInput();
        }

        return $resultado;
    }


    public function historial(Producto $producto): View
    {

        $producto = Producto::with([
            'historiales.formulas.familia',
            'historiales.formulas.insumo',
        ])->find($producto->idProducto);

        return view('productos.historial', compact('producto'));
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
