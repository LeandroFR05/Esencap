<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsumoRequest;
use App\Models\Familia;
use App\Models\Formula;
use App\Models\Insumo;
use App\Models\LoteInsumo;
use App\Services\InsumoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InsumoController extends Controller
{
    public function __construct(
        private InsumoService $insumoService
    ) {}
    

    public function insumos(Request $request): View {
        ['insumos' => $insumos, 'familias' => $familias] = $this->insumoService->obtenerInsumos($request);

        return view('insumos.estante', compact('insumos', 'familias'));
    }


    public function create(): View {
        $familias = Familia::all();
        return view('insumos.create', compact('familias'));
    }


    public function lotes($insumo): View
    {
        $insumo = Insumo::where('idInsumo', $insumo)->first();
        $lote = $insumo->lotes;

        return view('insumos.lotes', compact('insumo', 'lote'));
    }


    public function store(InsumoRequest $request): RedirectResponse {
        $this->insumoService->crearInsumo($request);

        return redirect()->route('insumos.create')->with('success', 'Insumo creado exitosamente.');
    }


    public function edit(Insumo $insumo): View {
        $familias = Familia::all();
        $stockActual = LoteInsumo::where('idInsumo', $insumo->idInsumo)->sum('stockActual');
        $formula = Formula::where('idInsumo', $insumo->idInsumo)->first();
        return view('insumos.edit', compact('insumo', 'familias', 'stockActual', 'formula'));
    }


    public function update(InsumoRequest $request, Insumo $insumo): RedirectResponse {
        $this->insumoService->actualizarInsumo($request, $insumo);

        return redirect()->route('insumos.edit', ['insumo' => $insumo->idInsumo])->with('success', 'Insumo actualizado exitosamente.');
    }
    

    public function reponer(Insumo $insumo): View {
        $ultimoNumero = LoteInsumo::where('idInsumo', $insumo->idInsumo)
            ->withTrashed()
            ->max('numeroLote');
        $nuevoNumero = $ultimoNumero ? $ultimoNumero + 1 : 1;

        return view('insumos.reponer', compact('insumo', 'nuevoNumero'));
    }


    public function reponerStore(InsumoRequest $request, Insumo $insumo): RedirectResponse {

        LoteInsumo::create([
            'idInsumo' => $insumo->idInsumo,
            // numeroLote se asigna automáticamente por el trigger
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


    public function historial(Request $request): View {
        $lotes = $this->insumoService->obtenerHistorial($request);

        return view('insumos.historial', compact('lotes'));
    }
}
