<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsumoRequest;
use App\Models\Familia;
use App\Models\Formula;
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
        $insumos = Insumo::withSum('lotes', 'stockActual')->paginate(10);
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
            'idFamilia' => $request->input('idFamilia'),
            'fase' => $request->input('fase'),
            'unidadDeMedida' => $request->input('unidadDeMedida')
        ]);

        LoteInsumo::create([
            'idInsumo' => $insumo->idInsumo,
            'numeroLote' => 1,
            'stockInicial' => $request->input('stockInicial'),
            'stockActual' => $request->input('stockInicial'),
            'fechaCompra' => $request->input('fechaCompra'),
            'fechaVencimiento' => $request->input('fechaVencimiento'),
        ]);

        return redirect()->route('insumos.create')->with('success', 'Insumo creado exitosamente.');
    }


    public function edit(Insumo $insumo): View {
        $familias = Familia::all();
        $stockActual = LoteInsumo::where('idInsumo', $insumo->idInsumo)->sum('stockActual');
        $formula = Formula::where('idInsumo', $insumo->idInsumo)->first();
        return view('insumos.edit', compact('insumo', 'familias', 'stockActual', 'formula'));
    }


    public function update(InsumoRequest $request, Insumo $insumo): RedirectResponse {
        $validated = $request->validated();

        // Para verificar si se eliminó la foto en el formulario, y no se volvió a cargar otra
        if ($request->remove_foto == '1') {
            if ($insumo->foto) {
                Storage::disk('public')->delete($insumo->foto);
            }
            $insumo->foto = null;
        }

        if ($request->hasFile('foto')) {
            if ($insumo->foto && Storage::disk('public')->exists($insumo->foto)) {
                Storage::disk('public')->delete($insumo->foto); // Eliminar la foto antigua
            }
            $fotoPath = $request->file('foto')->store('uploads', 'public');
            $validated['foto'] = $fotoPath; // Actualizar con la nueva foto
        }

        $insumo->update($validated);
        return redirect()->route('insumos.edit', ['insumo' => $insumo->idInsumo])->with('success', 'Insumo actualizado exitosamente.');
    }
    

    public function reponer(Insumo $insumo): View {
        $ultimoNumero = LoteInsumo::where('idInsumo', $insumo->idInsumo)
            ->max('numeroLote');
        $nuevoNumero = $ultimoNumero ? $ultimoNumero + 1 : 1;

        return view('insumos.reponer', compact('insumo', 'nuevoNumero'));
    }


    public function reponerStore(InsumoRequest $request, Insumo $insumo): RedirectResponse {

        LoteInsumo::create([
            'idInsumo' => $insumo->idInsumo,
            'numeroLote' => $request->input('numeroLote'),
            'stockInicial' => $request->input('stockInicial'),
            'stockActual' => $request->input('stockInicial'),
            'fechaCompra' => $request->input('fechaCompra'),
            'fechaVencimiento' => $request->input('fechaVencimiento'),
        ]);

        return redirect()->route('insumos.reponer', ['insumo' => $insumo->idInsumo])->with('success', 'Insumo repuesto exitosamente.');
    }


    public function eliminar(Insumo $insumo): RedirectResponse {
        $insumo->estado = false;
        $insumo->save();
        $insumo->delete();

        return redirect()->route('insumos.estante')->with('success', 'Insumo eliminado exitosamente.');
    }

    public function eliminados(): View {
        $insumosEliminados = Insumo::onlyTrashed()->get();
        return view('insumos.eliminados', compact('insumosEliminados'));
    }

    public function restore($idInsumo): RedirectResponse {
        $insumo = Insumo::onlyTrashed()->findOrFail($idInsumo);
        $insumo->restore();
        $insumo->estado = true;
        $insumo->save();

        return redirect()->route('insumos.eliminados')->with('success', 'Insumo restaurado exitosamente.');
    }

    // Esta función es para obtener los insumos vinculados a una determinada familia seleccionada en la fabricación de un producto.
    public function porFamilia($idFamilia): JsonResponse {
        $insumos = Insumo::where('idFamilia', $idFamilia)->get();
        return response()->json($insumos);
    }
}
