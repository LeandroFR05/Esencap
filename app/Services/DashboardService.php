<?php

namespace App\Services;

use App\Models\Insumo;
use App\Models\LoteInsumo;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function ventasRegistradasPorMes(?int $anio = null): array
    {
        $query = Venta::select(
            DB::raw('EXTRACT(MONTH FROM fecha) as mes'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('mes')
            ->orderBy('mes');

        if (!is_null($anio)) {
            $query->whereYear('fecha', $anio);
        }

        $ventas_mensuales = $query->get()->toArray();

        $ventas_data = array_fill(1, 12, 0);
        foreach ($ventas_mensuales as $venta) {
            $ventas_data[$venta['mes']] = $venta['total'];
        }

        return $ventas_data;
    }


    public function aniosDisponibles(): array
    {
        $anios = Venta::select(DB::raw('DISTINCT EXTRACT(YEAR FROM fecha) as anio'))
            ->orderBy('anio', 'desc')
            ->pluck('anio')
            ->toArray();

        if (empty($anios)) {
            $anios = [date('Y')];
        }

        return $anios;
    }


    public function porcentajeDeInsumosConBajoStock(): float
    {
        $insumos = Insumo::where('estado', 1)->get();
        $totalInsumos = LoteInsumo::count();
        $stockBajo = 0;

        foreach ($insumos as $insumo) {
            $stockMinimo = encontrarStockBajo($insumo);

            $stockBajo += LoteInsumo::where('idInsumo', $insumo->idInsumo)->where('stockActual', '<', $stockMinimo)->count();
        }

        return $totalInsumos > 0 ? round(($stockBajo / $totalInsumos) * 100, 2) : 0;
    }


    public function productosMasVendidos(?int $anio = null, ?int $mes = null): array
    {
        $query = DB::table('ventas as v')
            ->join('detalle_ventas as d', 'd.idVenta', '=', 'v.idVenta')
            ->join('productos as p', 'p.idProducto', '=', 'd.idProducto')
            ->select(
                'p.idProducto',
                'p.nombre as nombre',
                DB::raw('SUM(d.cantidad) as total_vendidos')
            )
            ->groupBy('p.idProducto', 'p.nombre')
            ->orderBy('total_vendidos', 'desc');

        if (!is_null($anio)) {
            $query->whereYear('v.fecha', $anio);
        }

        if (!is_null($mes)) {
            $query->whereMonth('v.fecha', $mes);
        }

        return $query->get()->toArray();
    }


    public function cantidadDeProductosVendidosPorDia(): array
    {
        return DB::table('ventas as v')
            ->join('detalle_ventas as d', 'd.idVenta', '=', 'v.idVenta')
            ->select(
                DB::raw('CAST(v.fecha AS DATE) as dia'),
                DB::raw('SUM(d.cantidad) as total')
            )
            ->groupBy('dia')
            ->orderBy('dia')
            ->get()
            ->toArray();
    }


    public function insumosProximosAVencer(): int
    {
        $hoy = date('Y-m-d');
        $insumos = Insumo::where('estado', 1)->get();
        $insumosProximosAVencer = 0;
        $resultado = 0;

        foreach ($insumos as $insumo) {
            $resultado += LoteInsumo::where('idInsumo', $insumo->idInsumo)
                ->where('fechaVencimiento', '<=', date('Y-m-d', strtotime($hoy.' +10 days')))
                ->limit(1)->count();
            if ($resultado > 0) {
                $insumosProximosAVencer++;
            }
            $resultado = 0;
        }

        return $insumosProximosAVencer;
    }


    public function insumosConBajoStock(): int
    {
        $insumos = Insumo::where('estado', 1)->get();
        $insumosBajoStock = 0;
        $resultado = 0;

        foreach ($insumos as $insumo) {
            $stockMinimo = encontrarStockBajo($insumo);

            $resultado += LoteInsumo::where('idInsumo', $insumo->idInsumo)
                ->where('stockActual', '<', $stockMinimo)
                ->limit(1)->count();
            if ($resultado > 0) {
                $insumosBajoStock++;
            }
            $resultado = 0;
        }

        return $insumosBajoStock;
    }


    public function insumosRegistrados(): int
    {
        return Insumo::count();
    }


    public function productosRegistrados(): int
    {
        return Producto::count();
    }
}
