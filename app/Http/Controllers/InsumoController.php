<?php

namespace App\Http\Controllers;

use App\Models\Familia;
use App\Models\Insumo;
use App\Models\LoteInsumo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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

    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:max_width=2000,max_height=2000',
        ]);

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
            'stock' => $request->input('stock'),
            'fechaVencimiento' => $request->input('fechaVencimiento'),
        ]);

        return redirect()->route('insumos.estante')->with('success', 'Insumo creado exitosamente.');
    }

    public function edit(Insumo $insumo): View {
        $familia = Familia::find($insumo->idFamilia);
        return view('insumos.edit', compact('insumo', 'familia'));
    }

    public function update(Request $request, Insumo $insumo): RedirectResponse {
        $insumo->update($request->all());
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
}
