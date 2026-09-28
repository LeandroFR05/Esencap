<?php

use App\Models\Insumo;
use Carbon\Carbon;

    if (!function_exists('obtenerFechaYHora')) {
        function obtenerFechaYHora($fecha): string {
            return Carbon::parse($fecha)
                ->setTime(Carbon::now()->hour, Carbon::now()->minute, Carbon::now()->second)
                ->format('Y-m-d H:i:s');
        }
    }

    if (!function_exists('encontrarStockBajo')) {
        function encontrarStockBajo(Insumo $insumo): int{
            $stockMinimo = match (strtolower($insumo->unidadDeMedida)) {
                'gramos'   => 500,
                'kilos'    => 1,
                'unidades' => 10,
                'litros'   => 2,
            };

            return $stockMinimo;
        }
    }
?>