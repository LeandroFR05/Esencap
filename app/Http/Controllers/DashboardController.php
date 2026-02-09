<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Venta;
use App\Models\Historial;
use App\Models\LoteInsumo;

class DashboardController extends Controller
{
    public function index()
    {
        $ventas_data = $this->ventasMensuales();
        $cantProductosVendidos = $this->cantidadProductosVendidos();
        $porcentajeStockBajo = $this->calcularPorcentajeStockBajo();

        $hoy = date('Y-m-d');
        $lotesProximosaVencer = LoteInsumo::where('fechaVencimiento', '<=', date('Y-m-d', strtotime($hoy . ' +30 days')))
            ->where('stock', '>', 0)->count();

        $lotesBajoStock = LoteInsumo::where('stock', '<=', 5)->count();

        return view('dashboard', compact('ventas_data', 'cantProductosVendidos', 'porcentajeStockBajo', 'lotesProximosaVencer', 
        'lotesBajoStock'));
    }


    // FUNCIONES PRIVADAS DE INDEX
    private function ventasMensuales()
    {
        $ventas_mensuales = Venta::select(
            DB::raw("MONTH(fecha) as mes"),
            DB::raw("COUNT(*) as total")
        )
        ->groupBy('mes')
        ->orderBy('mes')
        ->get()
        ->toArray();

        $ventas_data = array_fill(1, 12, 0);
        foreach ($ventas_mensuales as $venta) {
            $ventas_data[$venta['mes']] = $venta['total'];
        }

        return $ventas_data;
    }

    private function cantidadProductosVendidos()
    {
        return DB::table('ventas as v')
            ->join('productos as p', 'p.idProducto', '=', 'v.idProducto')
            ->select(
                'v.idProducto',
                'p.nombre as nombre',
                DB::raw('SUM(v.cantidad) as total_vendidos')
            )
            ->groupBy('v.idProducto', 'p.nombre')
            ->orderBy('total_vendidos', 'desc')
            ->get()
            ->toArray();
    }

    private function calcularPorcentajeStockBajo()
    {
        $limiteStockBajo = 5;
        $totalProductos = Historial::count();

        $stockBajo = Historial::where('stock', '<=', $limiteStockBajo)->count();
        $porcentajeStockBajo = $totalProductos > 0 ? ($stockBajo / $totalProductos) * 100 : 0;
        return $porcentajeStockBajo;
    }
}
