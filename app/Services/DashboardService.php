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
            DB::raw('MONTH(fecha) as mes'),
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
        $anios = Venta::select(DB::raw('DISTINCT YEAR(fecha) as anio'))
            ->orderBy('anio', 'desc')
            ->pluck('anio')
            ->toArray();

        if (empty($anios)) {
            $anios = [date('Y')];
        }

        return $anios;
    }


    public function insumosConBajoStock(): float
    {
        $insumos = Insumo::where('estado', 1)->get();
        $totalInsumos = LoteInsumo::count();
        $stockBajo = 0;

        foreach ($insumos as $insumo) {
            $stockMinimo = match (strtolower($insumo->unidadDeMedida)) {
                'gramos'   => 500,
                'kilos'    => 1,
                'unidades' => 10,
                'litros'   => 2,
            };

            $stockBajo += LoteInsumo::where('idInsumo', $insumo->idInsumo)->where('stockActual', '<', $stockMinimo)->count();
        }

        return $totalInsumos > 0 ? round(($stockBajo / $totalInsumos) * 100, 2) : 0;
    }


    public function productosMasVendidos(?int $anio = null, ?int $mes = null): array
    {
        $query = DB::table('ventas as v')
            ->join('detalleVentas as d', 'd.idVenta', '=', 'v.idVenta')
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
            ->join('detalleVentas as d', 'd.idVenta', '=', 'v.idVenta')
            ->select(
                DB::raw('DATE(v.fecha) as dia'),
                DB::raw('SUM(d.cantidad) as total')
            )
            ->groupBy('dia')
            ->orderBy('dia')
            ->get()
            ->toArray();
    }


    public function lotesProximosAVencer(): int
    {
        $hoy = date('Y-m-d');
        return LoteInsumo::where('fechaVencimiento', '<=', date('Y-m-d', strtotime($hoy.' +10 days')))->count();
    }


    public function lotesConBajoStock(): int
    {
        $insumos = Insumo::where('estado', 1)->get();
        $lotesBajoStock = 0;

        foreach ($insumos as $insumo) {
            $stockMinimo = match (strtolower($insumo->unidadDeMedida)) {
                'gramos' => 500,
                'kilos' => 1,
                'unidades' => 10,
                'litros' => 2,
            };

            $lotesBajoStock += LoteInsumo::where('idInsumo', $insumo->idInsumo)
                ->where('stockActual', '<', $stockMinimo)
                ->count();
        }

        return $lotesBajoStock;
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
