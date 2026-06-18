<?php

namespace App\Services;

use App\Models\Insumo;
use App\Models\LoteInsumo;
use Illuminate\Http\Request;

class InsumoService
{
    // Ubica el insumo y su contenido en pares dentro de un array asociativo
    public function mapearInsumos(Request $request): array
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
    public function descontarStockLotes(array $items): ?array
    {
        foreach ($items as $item) {
            $idInsumo = $item['idInsumo'];
            $contenidoNecesario = $item['contenido'];
            $contVencidos = 0;
            $insumo = Insumo::find($idInsumo);

            $sumaStock = LoteInsumo::where('idInsumo', $idInsumo)
                ->where('fechaVencimiento', '>=', now())
                ->sum('stockActual');
            $sumaStock = $this->convertirUnidad($sumaStock, $insumo->unidadDeMedida);

            // Obtenemos todos los lotes ordenados por fecha de vencimiento
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
                if ($lote->fechaVencimiento < now()) {
                    $contVencidos++;
                    continue; // Saltar lotes vencidos
                }

                if ($sumaStock >= $contenidoNecesario) {
                    // Convertimos el stock actual del lote a la unidad de gramos.
                    $contenidoDisponible = $this->convertirUnidad($lote->stockActual, $insumo->unidadDeMedida);

                    // Caso más simple: el stock disponible es mayor o igual al contenido necesario.
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

}

?>