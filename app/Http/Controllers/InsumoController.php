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
        $insumo = Insumo::create([
            'nombre' => $request->input('nombre'),
            'contenidoPorUnidad' => $request->input('contenidoPorUnidad'),
            'idFamilia' => $request->input('idFamilia'),
            'fase' => $request->input('fase'),
        ]);

        LoteInsumo::create([
            'idInsumo' => $insumo->id,
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
        LoteInsumo::create([
            'idInsumo' => $insumo->idInsumo,
            'stock' => $request->input('stock'),
            'fechaVencimiento' => $request->input('fechaVencimiento'),
        ]);

        return redirect()->route('insumos.estante')->with('success', 'Insumo repuesto exitosamente.');
    }
}
