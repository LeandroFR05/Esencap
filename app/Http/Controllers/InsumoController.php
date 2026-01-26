<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsumoRequest;
use App\Models\Familia;
use App\Models\Insumo;
use App\Models\LoteInsumo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class InsumoController extends Controller
{
    public function insumos(): View {
        $insumos = Insumo::all();
        return view('insumos.estante', compact('insumos'));
    }


    public function create(): View {
        $familias = Familia::all();
        return view('insumos.create', compact('familias'));
    }


    public function store(InsumoRequest $request): RedirectResponse {

        if ($request->hasFile('foto'))
            // Si se subió una imagen, la guardamos
            $fotoPath = $request->file('foto')->store('uploads', 'public');
        else 
            // Si no se subió nada, dejamos el valor en null
            $fotoPath = null;

        $insumo = Insumo::create([
            'nombre' => $request->input('nombre'),
            'foto' => $fotoPath,
            'contenidoPorUnidad' => $request->input('contenidoPorUnidad'),
            'idFamilia' => $request->input('idFamilia'),
            'fase' => $request->input('fase'),
        ]);

        LoteInsumo::create([
            'idInsumo' => $insumo->idInsumo,
            'numeroLote' => 1,
            'stock' => $request->input('stock') * $insumo->contenidoPorUnidad,
            'fechaVencimiento' => $request->input('fechaVencimiento'),
        ]);

        return redirect()->route('insumos.estante')->with('success', 'Insumo creado exitosamente.');
    }


    public function edit(Insumo $insumo): View {
        $familias = Familia::all();
        $stockLotes = LoteInsumo::where('idInsumo', $insumo->idInsumo)->sum('stock');
        return view('insumos.edit', compact('insumo', 'familias', 'stockLotes'));
    }


    public function update(InsumoRequest $request, Insumo $insumo): RedirectResponse {

        $validated = $request->validated();
        if ($request->hasFile('foto')) {
            if ($insumo->foto && Storage::disk('public')->exists($insumo->foto)) {
                Storage::disk('public')->delete($insumo->foto); // Eliminar la foto antigua
            }
            $fotoPath = $request->file('foto')->store('uploads', 'public');
            $validated['foto'] = $fotoPath; // Actualizar con la nueva foto
        }

        $insumo->update($validated);
        return redirect()->route('insumos.estante')->with('success', 'Insumo actualizado exitosamente.');
    }
    

    public function reponer(Insumo $insumo): View {
        return view('insumos.reponer', compact('insumo'));
    }


    public function reponerStore(Request $request, Insumo $insumo): RedirectResponse {

        $ultimoNumero = LoteInsumo::where('idInsumo', $insumo->idInsumo)
            ->max('numeroLote');
        $nuevoNumero = $ultimoNumero ? $ultimoNumero + 1 : 1;

        LoteInsumo::create([
            'idInsumo' => $insumo->idInsumo,
            'numeroLote' => $nuevoNumero,
            'stock' => $request->input('stock'),
            'fechaVencimiento' => $request->input('fechaVencimiento'),
        ]);

        return redirect()->route('insumos.estante')->with('success', 'Insumo repuesto exitosamente.');
    }


    public function deshabilitar(Insumo $insumo): RedirectResponse {
        $insumo->update(['disponible' => false]);
        return redirect()->route('insumos.estante')->with('danger', 'Insumo deshabilitado exitosamente.');
    }

    // Esta función es para obtener los insumos vinculados a una determinada familia seleccionada en la fabricación de un producto.
    public function porFamilia($idFamilia): JsonResponse {
        $insumos = Insumo::where('idFamilia', $idFamilia)->get();
        return response()->json($insumos);
    }



    
    /* public function eliminar(Insumo $insumo): RedirectResponse {
        // Eliminar la foto asociada si existe
        if ($insumo->foto && Storage::disk('public')->exists($insumo->foto)) {
            Storage::disk('public')->delete($insumo->foto);
        }

        // Eliminar el insumo
        $insumo->delete();

        return redirect()->route('insumos.estante')->with('danger', 'Insumo eliminado exitosamente.');
    }
    */
}
