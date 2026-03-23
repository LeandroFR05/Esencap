<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Venta;
use App\Models\Historial;
use App\Models\LoteInsumo;
use App\Models\Insumo;
use App\Models\Producto;

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
        $lotesProximosaVencer = LoteInsumo::where('fechaVencimiento', '<=', date('Y-m-d', strtotime($hoy . ' +10 days')))
            ->where('stockActual', '>', 0)->count();

        $insumos = Insumo::all();
        $lotesAgrupados = collect();
        $lotesBajoStock = 0;

        foreach ($insumos as $insumo) {
            // Definir el stock mínimo según la unidad de medida
            $stockMinimo = match (strtolower($insumo->unidadDeMedida)) {
                'gramos'   => 500,
                'kilos'    => 1,
                'unidades' => 10,
                'litros'   => 2,
                default    => 5,
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


    private function ventasDiarias()
    {
        $ventas_diarias = Venta::select(
            DB::raw("DATE(fecha) as dia"),
            DB::raw("SUM(cantidad) as total")  // O COUNT(*) si prefieres número de ventas
        )
        ->where('fecha', '>=', now()->subDays(30))
        ->groupBy('dia')
        ->orderBy('dia')
        ->get()
        ->toArray();

        return $ventas_diarias;  // Retorna array con ['dia' => '2023-01-01', 'total' => 10]
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

        $stockBajo = Historial::where('stockActual', '<=', $limiteStockBajo)->count();
        $porcentajeStockBajo = $totalProductos > 0 ? round(($stockBajo / $totalProductos) * 100, 2) : 0;
        return $porcentajeStockBajo;
    }
}
