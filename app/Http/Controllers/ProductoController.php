<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\ProductoRequest;
use App\Models\Historial;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Familia;
use App\Models\FormulaBase;
use App\Models\FormulaRecalculada;
use App\Models\Insumo;
use Illuminate\Http\Request;
use App\Models\LoteInsumo;

use function Laravel\Prompts\alert;

class ProductoController extends Controller
{
    public function productos(): View {
        $productos = Producto::all();
        return view('productos.estante', compact('productos'));
    }


    public function create(): View {
        $familias = Familia::all();
        return view('productos.create', compact('familias'));
    }


    public function store(ProductoRequest $request): RedirectResponse {
        try {
            //Con estas funciones comprobamos de que haya suficiente stock de los insumos, y los descontamos en los lotes
            $items = $this->mapearInsumos($request);
            $this->descontarStockLotes($items);
            
            //Si está todo correcto, procedemos a crear el producto y sus relaciones
            $fotoPath = $this->guardarFoto($request);
            $producto = $this->crearProducto($request, $fotoPath);
            $this->crearHistorial($producto, $request);
            $this->crearFormulas($producto, $request);

            $resultado = redirect()->route('productos.estante')->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
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

        foreach ($request->idInsumo as $index => $idInsumo) {
            $items[] = [
                'idInsumo'  => $idInsumo,
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

            $lotes = LoteInsumo::where('idInsumo', $idInsumo)
                ->where('stock', '>', 0)
                ->orderBy('fechaVencimiento', 'asc')
                ->get();

            foreach ($lotes as $lote) {
                if ($contenidoNecesario <= 0) {
                    break;
                }
                if ($lote->stock >= $contenidoNecesario) {
                    $lote->stock -= $contenidoNecesario;
                    $lote->save();
                    $contenidoNecesario = 0;
                } 
            }
            if ($contenidoNecesario > 0) {
                $nombreInsumo = Insumo::find($idInsumo)->nombre;
                throw new \Exception("El insumo {$nombreInsumo} no tiene stock suficiente.");
            }
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
        $base = Producto::max('idBase') + 1;
        $recalculada = Producto::max('idRecalculada') + 1;

        return Producto::create([
            'nombre' => $request->nombre,
            'foto' => $fotoPath,
            'contenidoPorUnidad' => $request->contenidoPorUnidad,
            'idBase' => $base,
            'idRecalculada' => $recalculada,
        ]);
    }


    private function crearHistorial(Producto $producto, Request $request): void
    {
        Historial::create([
            'idProducto' => $producto->idProducto,
            'stock' => $request->stock,
            'fechaElaboracion' => $request->fechaElaboracion,
        ]);
    }
    

    private function crearFormulas(Producto $producto, Request $request): void
    {
        $cantidad = count($request->porcentaje);

        //Recorremos los arrays para crear las fórmulas
        for ($i = 0; $i < $cantidad; $i++) {
            FormulaBase::create([
                'idBase' => $producto->idBase,
                'idFamilia' => $request->idFamilia[$i],
                'porcentaje' => $request->porcentaje[$i],
            ]);

            FormulaRecalculada::create([
                'idRecalculada' => $producto->idRecalculada,
                'idInsumo' => $request->idInsumo[$i],
                'contenido' => $request->contenido[$i],
            ]);
        }
    }
    
}



