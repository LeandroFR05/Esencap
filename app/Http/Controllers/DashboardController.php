<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;
use App\Models\Historial;

class DashboardController extends Controller
{
    public function index()
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


        $cantProductosVendidos = DB::table('ventas as v')
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


        $limiteStockBajo = 5;
        $totalProductos = Historial::count();

        $stockBajo = Historial::where('stock', '<=', $limiteStockBajo)->count();
        $porcentajeStockBajo = $totalProductos > 0 ? ($stockBajo / $totalProductos) * 100 : 0;

        return view('dashboard', compact('ventas_data', 'cantProductosVendidos', 'porcentajeStockBajo'));
    }
}
