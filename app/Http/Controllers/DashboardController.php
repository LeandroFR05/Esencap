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
        // Gráficos
        $ventas_data = $this->ventasRegistradasPorMes();
        $porcentajeStockBajo = $this->productosConBajoStock();
        $cantProductosVendidos = $this->productosMasVendidos();
        $ventasDiarias = $this->cantidadDeProductosVendidosPorDia();

        // Tarjetas
        $lotesProximosaVencer = $this->lotesProximosAVencer();
        $lotesBajoStock = $this->lotesConBajoStock();
        $insumosRegistrados = $this->insumosRegistrados();
        $productosRegistrados = $this->productosRegistrados();
        
        return view('dashboard', compact('ventas_data', 'porcentajeStockBajo', 'cantProductosVendidos', 'ventasDiarias', 
            'lotesProximosaVencer', 'lotesBajoStock', 'insumosRegistrados', 'productosRegistrados'));
    }



    // FUNCIONES PRIVADAS DE INDEX
    // Gráficos
    private function ventasRegistradasPorMes()
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


    private function productosConBajoStock()
    {
        $limiteStockBajo = 5;
        $totalProductos = Historial::count();

        $stockBajo = Historial::where('stockActual', '<=', $limiteStockBajo)->count();
        $porcentajeStockBajo = $totalProductos > 0 ? round(($stockBajo / $totalProductos) * 100, 2) : 0;

        return $porcentajeStockBajo;
    }


    private function productosMasVendidos()
    {
        return DB::table('ventas as v')
            ->join('carritos as c', 'c.idVenta', '=', 'v.idVenta')
            ->join('productos as p', 'p.idProducto', '=', 'c.idProducto')
            ->select(
                'p.idProducto',
                'p.nombre as nombre',
                DB::raw('SUM(c.cantidad) as total_vendidos')
            )
            ->groupBy('p.idProducto', 'p.nombre')
            ->orderBy('total_vendidos', 'desc')
            ->get()
            ->toArray();
    }


    private function cantidadDeProductosVendidosPorDia()
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


    // Tarjetas
    public function lotesProximosAVencer()
    {
        $hoy = date('Y-m-d');
        return LoteInsumo::where('fechaVencimiento', '<=', date('Y-m-d', strtotime($hoy.' +10 days')))->count();
    }
    
    public function lotesConBajoStock()
    {
        $insumos = Insumo::where('estado', 1)->get();
        $lotesBajoStock = 0;

        foreach ($insumos as $insumo) {
            // Definir el stock mínimo según la unidad de medida
            $stockMinimo = match (strtolower($insumo->unidadDeMedida)) {
                'gramos' => 500,
                'kilos' => 1,
                'unidades' => 10,
                'litros' => 2,
            };

            // Buscar lotes de ese insumo con stock bajo
            $lotesBajoStock += LoteInsumo::where('idInsumo', $insumo->idInsumo)
                ->where('stockActual', '<=', $stockMinimo)
                ->count();
        }

        return $lotesBajoStock;
    }


    private function insumosRegistrados()
    {
        return Insumo::count();
    }


    private function productosRegistrados()
    {
        return Producto::count();
    }
}
