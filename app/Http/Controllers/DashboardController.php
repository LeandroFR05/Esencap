<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Models\Insumo;
use App\Models\LoteInsumo;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $ventas_data = $this->ventasMensuales();
        $cantProductosVendidos = $this->cantidadProductosVendidos();
        $porcentajeStockBajo = $this->calcularPorcentajeStockBajo();
        $ventasDiarias = $this->ventasDiarias();
        $insumosRegistrados = $this->insumosRegistrados();
        $productosRegistrados = $this->productosRegistrados();

        $hoy = date('Y-m-d');
        $lotesProximosaVencer = LoteInsumo::where('fechaVencimiento', '<=', date('Y-m-d', strtotime($hoy.' +10 days')))
            ->where('stockActual', '>', 0)->count();

        $insumos = Insumo::all();
        $lotesAgrupados = collect();
        $lotesBajoStock = 0;

        foreach ($insumos as $insumo) {
            // Definir el stock mínimo según la unidad de medida
            $stockMinimo = match (strtolower($insumo->unidadDeMedida)) {
                'gramos' => 500,
                'kilos' => 1,
                'unidades' => 10,
                'litros' => 2,
                default => 5,
            };

            // Buscar lotes de ese insumo con stock bajo
            $lotesBajoStock += LoteInsumo::where('idInsumo', $insumo->idInsumo)
                ->where('stockActual', '<=', $stockMinimo)
                ->count();
        }

        return view('dashboard', compact('ventas_data', 'cantProductosVendidos', 'porcentajeStockBajo', 'lotesProximosaVencer',
            'lotesBajoStock', 'ventasDiarias', 'insumosRegistrados', 'productosRegistrados'));
    }

    // FUNCIONES PRIVADAS DE INDEX
    private function insumosRegistrados()
    {
        return Insumo::count();
    }


    private function productosRegistrados()
    {
        return Producto::count();
    }

    private function ventasMensuales()
    {
        $ventas_mensuales = Venta::select(
            DB::raw('MONTH(fecha) as mes'),
            DB::raw('COUNT(*) as total')
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

    private function ventasDiarias()
    {
        $ventas_diarias = DB::table('ventas as v')
            ->join('carritos as c', 'c.idVenta', '=', 'v.idVenta')
            ->select(
                DB::raw('DATE(v.fecha) as dia'),
                DB::raw('SUM(c.cantidad) as total')
            )
            ->where('v.fecha', '>=', now()->subDays(30))
            ->groupBy('dia')
            ->orderBy('dia')
            ->get()
            ->toArray();

        return $ventas_diarias;
    }

    private function cantidadProductosVendidos()
    {
        return DB::table('ventas as v')
            ->join('carritos as c', 'c.idVenta', '=', 'v.idVenta')
            ->join('productos as p', 'p.idProducto', '=', 'c.idProducto')
            ->select(
                DB::raw('DATE(v.fecha) as dia'),
                'p.idProducto',
                'p.nombre as nombre',
                DB::raw('SUM(c.cantidad) as total_vendidos')
            )
            ->groupBy('dia', 'p.idProducto', 'p.nombre')
            ->orderBy('dia', 'desc')
            ->orderBy('total_vendidos', 'desc')
            ->get()
            ->toArray();
    }

    private function calcularPorcentajeStockBajo()
    {
        $limiteStockBajo = 5;
        $totalProductos = Historial::count();

        $stockBajo = Historial::where('stockActual', '<=', $limiteStockBajo)->count();
        $porcentajeStockBajo = $totalProductos > 0 ? round(($stockBajo / $totalProductos) * 100, 2) : 0;

        return $porcentajeStockBajo;
    }
}
