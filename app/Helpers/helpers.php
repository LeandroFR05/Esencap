<?php

use App\Models\Insumo;

    function encontrarStockBajo(Insumo $insumo): int{
        $stockMinimo = match (strtolower($insumo->unidadDeMedida)) {
            'gramos'   => 500,
            'kilos'    => 1,
            'unidades' => 10,
            'litros'   => 2,
        };

        return $stockMinimo;
    }
?>