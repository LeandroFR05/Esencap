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
use Illuminate\Http\Request;

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

        if ($request->hasFile('foto'))
            // Si se subió una imagen, la guardamos
            $fotoPath = $request->file('foto')->store('uploads', 'public');
        else 
            // Si no se subió nada, dejamos el valor en null
            $fotoPath = null;

        $producto = Producto::create([
            'nombre' => $request->input('nombre'),
            'foto' => $fotoPath,
            'contenidoPorUnidad' => $request->input('contenidoPorUnidad'),
            'idBase' => 1,
            'idRecalculada' => 1    
        ]);

        Historial::create([
            'idProducto' => $producto->idProducto,
            'stock' => $request->input('stock'),
            'fechaElaboracion' => $request->input('fechaElaboracion')
        ]);

        $porcentajes = $request->porcentaje;
        $familias = $request->idFamilia;
        $contenidos = $request->contenido;
        $insumos = $request->idInsumo;
        
        $cantidad = count($porcentajes);

        // Para cargar las fórmulas base y recalculada en la base de datos debemos recorrer los arrays
        for($i=0; $i<$cantidad; $i++) {
            FormulaBase::create([
                'idBase' => $producto->idBase,
                'idFamilia' => $familias[$i],
                'porcentaje' => $porcentajes[$i],
            ]);

            FormulaRecalculada::create([
                'idRecalculada' => $producto->idRecalculada,
                'idInsumo' => $insumos[$i],
                'contenido' => $contenidos[$i],
            ]);
        }

        return redirect()->route('productos.estante')->with('success', 'Producto creado exitosamente.');
    }
    
}
