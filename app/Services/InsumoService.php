<?php

namespace App\Services;

use App\Http\Requests\InsumoRequest;
use App\Models\Familia;
use App\Models\Insumo;
use App\Models\LoteInsumo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InsumoService
{
    public function __construct(
        private ImageService $imageService
    ) {}

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
    public function descontarStockLotes(Request $request): ?array
    {
        $items = $this->mapearInsumos($request);
        
        foreach ($items as $item) {
            $idInsumo = $item['idInsumo'];
            $contenidoNecesario = $item['contenido']; // Es lo que necesitamos para la elaboración del producto
            $contVencidos = 0;
            $insumo = Insumo::find($idInsumo); // Se busca el insumo en la bd

            $sumaStock = LoteInsumo::where('idInsumo', $idInsumo)
                ->where('fechaVencimiento', '>=', now())
                ->sum('stockActual'); // Se obtiene la suma de stock actual de todos los lotes que no estén vencidos
            $sumaStock = $this->convertirUnidad($sumaStock, $insumo->unidadDeMedida); // Convierte todo a gramos

            // Obtenemos todos los lotes ordenados por fecha de vencimiento del insumo
            $lotes = LoteInsumo::where('idInsumo', $idInsumo)
                ->orderBy('fechaVencimiento', 'asc')
                ->get();

            foreach ($lotes as $lote) {
                if ($contenidoNecesario <= 0) {
                    break;
                }
                if ($lote->stockActual <= 0) {
                    continue; // Saltar lotes sin stock
                }

                $fechaVencimiento = Carbon::parse($lote->getRawOriginal('fechaVencimiento'));
                if ($fechaVencimiento->lt(now())) {
                    $contVencidos++; // Se cuentan los lotes vencidos
                    continue; // Saltar lotes vencidos
                }

                if ($sumaStock >= $contenidoNecesario) {
                    // Convertimos el stock actual del lote a la unidad de gramos.
                    $contenidoDisponible = $this->convertirUnidad($lote->stockActual, $insumo->unidadDeMedida);

                    // Caso más simple: el stock disponible del lote es mayor o igual al contenido necesario.
                    if ($contenidoDisponible >= $contenidoNecesario) {
                        $contenidoDisponible -= $contenidoNecesario;
                        $lote->stockActual = ($contenidoDisponible * $lote->stockActual) / $this->convertirUnidad($lote->stockActual, $insumo->unidadDeMedida);
                        $lote->save();
                        $contenidoNecesario = 0;
                    } 
                    // Caso contrario: el stock disponible es menor al contenido necesario.
                    else {
                        $contenidoNecesario -= $contenidoDisponible;
                        $lote->stockActual = 0;
                        $lote->save();
                    }
                }
            }
            
            // Si el contenidoNecesario sigue siendo mayor a 0, significa que no había suficiente stock en los lotes disponibles.
            if ($contenidoNecesario > 0) {
                $nombreInsumo = $insumo->nombre;

                return [
                    'insumo' => $nombreInsumo,
                    'idInsumo' => $idInsumo,
                    'unidad' => $insumo->unidadDeMedida,
                    'stockDisponible' => round($sumaStock, 2),
                    'necesario' => round($contenidoNecesario, 2),
                    'lotesVencidos' => $contVencidos,
                    'lotes' => $lotes,
                ];
            }
        }

        return null;
    }

    public function convertirUnidad(float $valor, string $unidad): float
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


    public function obtenerInsumos(Request $request): array
    {
        $familias = Familia::all();
        $insumos = Insumo::withSum('lotes', 'stockActual')
            ->when($request->filled('familia'), function ($query) use ($request) {
                $query->where('idFamilia', $request->familia);
            })
            ->when($request->filled('ordenarFecha'), function ($query) use ($request) {
                $direccion = $request->ordenarFecha === 'reciente' ? 'desc' : 'asc';
                $query->orderBy(
                    LoteInsumo::selectRaw('MAX(??)', ['lote_insumos.fechaCompra'])
                        ->whereColumn('lote_insumos.idInsumo', 'insumos.idInsumo'),
                    $direccion
                );
            })
            ->paginate(10)
            ->appends($request->query());

        return compact('insumos', 'familias');
    }

    public function crearInsumo(Request $request): Insumo
    {
        $fotoPath = $request->hasFile('foto')
            ? $this->imageService->storeAsWebp($request->file('foto'))
            : null;

        $insumo = Insumo::create([
            'nombre' => $request->input('nombre'),
            'foto' => $fotoPath,
            'idFamilia' => $request->input('idFamilia'),
            'fase' => $request->input('fase'),
            'unidadDeMedida' => $request->input('unidadDeMedida')
        ]);

        LoteInsumo::create([
            'idInsumo' => $insumo->idInsumo,
            'stockInicial' => $request->input('stockInicial'),
            'stockActual' => $request->input('stockInicial'),
            'fechaCompra' => $request->input('fechaCompra'),
            'fechaVencimiento' => $request->input('fechaVencimiento'),
        ]);

        return $insumo;
    }

    public function actualizarInsumo(Request $request, Insumo $insumo): void
    {
        $validated = $request->validated();

        if ($request->input('remove_foto') == '1') {
            if ($insumo->foto) {
                Storage::disk('public')->delete($insumo->foto);
            }
            $insumo->foto = null;
        }

        if ($request->hasFile('foto')) {
            if ($insumo->foto && Storage::disk('public')->exists($insumo->foto)) {
                Storage::disk('public')->delete($insumo->foto);
            }
            $validated['foto'] = $this->imageService->storeAsWebp($request->file('foto'));
        }

        $insumo->update($validated);
    }

    public function obtenerHistorial(Request $request)
    {
        $query = LoteInsumo::with('insumo')->withTrashed();

        if ($request->filled('insumo')) {
            $query->whereHas('insumo', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->insumo . '%');
            });
        }

        if ($request->filled('fechaCompra')) {
            $query->whereDate('fechaCompra', $request->fechaCompra);
        }

        if ($request->filled('fechaVencimiento')) {
            $query->whereDate('fechaVencimiento', $request->fechaVencimiento);
        }

        return $query->paginate(10)->appends($request->query());
    }

}

?>